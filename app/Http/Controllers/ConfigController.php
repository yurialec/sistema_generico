<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function downloadBackup()
    {
        $disk = Storage::disk('local');
        $dir = 'backups';
        if (!$disk->exists($dir)) {
            $disk->makeDirectory($dir);
        }

        $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $relativePath = $dir . '/' . $filename;
        $fullPath = storage_path('app/' . $relativePath);

        $conn = config('database.default');
        $cfg = config("database.connections.$conn");

        try {
            switch ($cfg['driver']) {
                case 'mysql':
                    // Atenção a espaços/senha vazia
                    $passwordPart = isset($cfg['password']) && $cfg['password'] !== '' ? " -p\"{$cfg['password']}\"" : '';
                    $cmd = sprintf(
                        'mysqldump -h %s -P %s -u %s%s %s > %s',
                        escapeshellarg($cfg['host'] ?? '127.0.0.1'),
                        escapeshellarg((string) ($cfg['port'] ?? 3306)),
                        escapeshellarg($cfg['username']),
                        $passwordPart,
                        escapeshellarg($cfg['database']),
                        escapeshellarg($fullPath)
                    );
                    break;

                case 'pgsql':
                case 'postgres':
                    // pg_dump usa variável de ambiente para senha
                    $env = 'PGPASSWORD=' . escapeshellarg($cfg['password'] ?? '');
                    $cmd = sprintf(
                        '%s pg_dump -h %s -p %s -U %s -F p %s > %s',
                        $env,
                        escapeshellarg($cfg['host'] ?? '127.0.0.1'),
                        escapeshellarg((string) ($cfg['port'] ?? 5432)),
                        escapeshellarg($cfg['username']),
                        escapeshellarg($cfg['database']),
                        escapeshellarg($fullPath)
                    );
                    break;

                case 'sqlite':
                    // Exporta schema+dados em SQL
                    $dbPath = $cfg['database'];
                    $cmd = sprintf(
                        'sqlite3 %s .dump > %s',
                        escapeshellarg($dbPath),
                        escapeshellarg($fullPath)
                    );
                    break;

                default:
                    throw new \RuntimeException("Driver {$cfg['driver']} não suportado por este método.");
            }

            // Executa o comando
            $resultCode = null;
            $output = [];
            exec($cmd, $output, $resultCode);
            if ($resultCode !== 0 || !file_exists($fullPath)) {
                throw new \RuntimeException('Falha ao executar comando de dump. Verifique PATH e credenciais.');
            }
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => 'Falha ao gerar backup: ' . $e->getMessage(),
            ], 500);
        }

        return response()->download($fullPath)->deleteFileAfterSend(true);
    }
}
