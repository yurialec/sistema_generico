<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {namespace} {name}';
    protected $description = 'Cria Controller, Service, Repository, Interface, Model, Views, adiciona permissão e rotas (CRUD)';

    public function handle()
    {
        $namespace = Str::studly($this->argument('namespace')); // Ex: Admin
        $name = Str::studly($this->argument('name'));       // Ex: Feedback

        // Variantes
        $camel = Str::camel($name);                 // feedback
        $kebab = Str::kebab($name);                 // feedback
        $tableName = strtolower(Str::snake(Str::pluralStudly($name))); // feedbacks

        // Variáveis
        $varModel = $camel;
        $varService = $camel . 'Service';
        $varRepository = $camel . 'Repository';

        // Views: diretório e namespace
        $viewDir = strtolower($namespace . '/' . $kebab);   // admin/feedback
        $viewNamespace = strtolower($namespace . '.' . $kebab);   // admin.feedback

        // Diretórios
        $dirs = [
            "app/Http/Controllers/{$namespace}",
            "app/Services/{$namespace}",
            "app/Repositories/{$namespace}",
            "app/Interfaces/{$namespace}",
            "app/Models/{$namespace}",
            "resources/views/{$viewDir}",
        ];
        foreach ($dirs as $dir) {
            if (!File::exists($dir))
                File::makeDirectory($dir, 0755, true);
        }

        // ---------------- Templates ----------------
        $controller = <<<PHP
<?php

namespace App\Http\Controllers\\{$namespace};

use App\Http\Controllers\Controller;
use App\Services\\{$namespace}\\{$name}Service;
use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    protected \${$varService};

    public function __construct({$name}Service \${$varService})
    {
        \$this->{$varService} = \${$varService};
    }

    public function index()
    {
        return view('{$viewNamespace}.index');
    }

    public function list(Request \$request)
    {
        \$items = \$this->{$varService}->getAll(\$request->input('search'));

        if (\$items) {
            return response()->json(['status' => true, 'items' => \$items], 200);
        }
        return response()->json(['message' => 'Nenhum registro encontrado.', 'status' => 500]);
    }

    public function create()
    {
        return view('{$viewNamespace}.create');
    }

    public function store(Request \$request)
    {
        \$item = \$this->{$varService}->create(\$request->all());

        if (\$item) {
            return response()->json(['status' => true, 'item' => \$item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao cadastrar registro'], 500);
    }

    public function edit(\$id)
    {
        return view('{$viewNamespace}.edit', compact('id'));
    }

    public function find(\$id)
    {
        \$item = \$this->{$varService}->find(\$id);

        if (\$item) {
            return response()->json(['status' => true, 'item' => \$item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }

    public function update(Request \$request, string \$id)
    {
        \$item = \$this->{$varService}->update(\$id, \$request->all());

        if (\$item) {
            return response()->json(['status' => true, 'item' => \$item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao atualizar registro'], 500);
    }

    public function delete(string \$id)
    {
        \$deleted = \$this->{$varService}->delete(\$id);

        if (\$deleted) {
            return response()->json(['status' => true, 'message' => 'Registro excluído com sucesso'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao excluir registro'], 500);
    }
}
PHP;

        $service = <<<PHP
<?php

namespace App\Services\\{$namespace};

use App\Repositories\\{$namespace}\\{$name}Repository;

class {$name}Service
{
    protected \${$varRepository};

    public function __construct({$name}Repository \${$varRepository})
    {
        \$this->{$varRepository} = \${$varRepository};
    }

    public function getAll(\$term)
    {
        return \$this->{$varRepository}->all(\$term);
    }

    public function find(\$id)
    {
        return \$this->{$varRepository}->find(\$id);
    }

    public function create(\$data)
    {
        return \$this->{$varRepository}->create(\$data);
    }

    public function update(\$id, \$data)
    {
        // solicitado: repassar \$data sem tratamento
        return \$this->{$varRepository}->update(\$id, \$data);
    }

    public function delete(\$id)
    {
        return \$this->{$varRepository}->delete(\$id);
    }
}
PHP;

        $repository = <<<PHP
<?php

namespace App\Repositories\\{$namespace};

use App\Interfaces\\{$namespace}\\{$name}RepositoryInterface;
use App\Models\\{$namespace}\\{$name};
use Exception;
use Illuminate\Support\Facades\Log;

class {$name}Repository implements {$name}RepositoryInterface
{
    protected \${$varModel};

    public function __construct({$name} \${$varModel})
    {
        \$this->{$varModel} = \${$varModel};
    }

    public function all(\$term)
    {
        try {
            return \$this->{$varModel}
                ->when(\$term, function (\$query) use (\$term) {
                    // ajuste seus campos de busca aqui (ex.: 'name')
                    return \$query->where('id', 'like', '%' . \$term . '%');
                })
                ->paginate(10);
        } catch (Exception \$err) {
            Log::error('Erro ao listar registros {$name}', [\$err->getMessage()]);
            return false;
        }
    }

    public function find(\$id)
    {
        try {
            return \$this->{$varModel}->find(\$id);
        } catch (Exception \$err) {
            Log::error('Erro ao localizar registro {$name}', [\$err->getMessage()]);
            return false;
        }
    }

    public function create(array \$data)
    {
        try {
            return \$this->{$varModel}->create(\$data);
        } catch (Exception \$err) {
            Log::error('Erro ao cadastrar {$name}', [\$err->getMessage()]);
            return false;
        }
    }

    public function update(\$id, array \$data)
    {
        try {
            \$item = \$this->{$varModel}->find(\$id);
            \$item->update(\$data);
            return \$item;
        } catch (Exception \$err) {
            Log::error('Erro ao atualizar {$name}', [\$err->getMessage()]);
            return false;
        }
    }

    public function delete(\$id)
    {
        try {
            \$item = \$this->{$varModel}->find(\$id);
            \$item->delete();
            return true;
        } catch (Exception \$err) {
            Log::error('Erro ao excluir {$name}', [\$err->getMessage()]);
            return false;
        }
    }
}
PHP;

        $interface = <<<PHP
<?php

namespace App\Interfaces\\{$namespace};

interface {$name}RepositoryInterface
{
    public function all(\$term);
    public function find(\$id);
    public function create(array \$data);
    public function update(\$id, array \$data);
    public function delete(\$id);
}
PHP;

        $model = <<<PHP
<?php

namespace App\Models\\{$namespace};

use Illuminate\Database\Eloquent\Model;

class {$name} extends Model
{
    protected \$table = '{$tableName}';
    protected \$guarded = [];
}
PHP;

        // Views placeholder
        $indexView = <<<BLADE
@extends('admin.layouts.app_admin')
@section('content')
<div class="container">
    <h1>{$name} - Index</h1>
</div>
@endsection
BLADE;

        $createView = <<<BLADE
@extends('admin.layouts.app_admin')
@section('content')
<div class="container">
    <h1>{$name} - Create</h1>
</div>
@endsection
BLADE;

        $editView = <<<BLADE
@extends('admin.layouts.app_admin')
@section('content')
<div class="container">
    <h1>{$name} - Edit</h1>
    <p>ID: {{ \$id }}</p>
</div>
@endsection
BLADE;

        // ---------------- Grava arquivos ----------------
        $files = [
            "app/Http/Controllers/{$namespace}/{$name}Controller.php" => $controller,
            "app/Services/{$namespace}/{$name}Service.php" => $service,
            "app/Repositories/{$namespace}/{$name}Repository.php" => $repository,
            "app/Interfaces/{$namespace}/{$name}RepositoryInterface.php" => $interface,
            "app/Models/{$namespace}/{$name}.php" => $model,
            "resources/views/{$viewDir}/index.blade.php" => $indexView,
            "resources/views/{$viewDir}/create.blade.php" => $createView,
            "resources/views/{$viewDir}/edit.blade.php" => $editView,
        ];

        foreach ($files as $path => $content) {
            if (!File::exists($path)) {
                File::put($path, $content);
                $this->info("Criado: {$path}");
            } else {
                $this->warn("Ignorado (já existe): {$path}");
            }
        }

        // --------------- Permissão na tabela permissions ---------------
        $this->upsertPermission($kebab);

        // ---------------- Injetar rotas em routes/web.php ----------------
        $this->appendRoutesToWeb($namespace, $name, $kebab);

        $this->line('');
        $this->info("✅ Módulo {$namespace}/{$name} criado com sucesso!");
    }

    /**
     * Cria/atualiza a permissão na tabela 'permissions' no padrão:
     * name: keep-{$kebab}, label: Manter {Headline}
     */
    protected function upsertPermission(string $kebab): void
    {
        try {
            $name = "keep-{$kebab}";
            $label = 'Manter ' . Str::headline($kebab); // ex.: feedback -> Feedback | site-about -> Site About

            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                [
                    'label' => $label,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            $this->info("Permissão inserida/atualizada: {$name} ({$label})");
        } catch (\Throwable $e) {
            $this->warn("Não foi possível inserir a permissão em 'permissions': " . $e->getMessage());
        }
    }

    /**
     * Adiciona, se não existir, o bloco de rotas admin/{kebab}
     * protegido por auth e acl:keep-{kebab}, com nomes como feedback.index
     */
    protected function appendRoutesToWeb(string $namespace, string $name, string $kebab): void
    {
        $webPath = base_path('routes/web.php');
        if (!File::exists($webPath)) {
            $this->warn('routes/web.php não encontrado. Pulei a etapa de rotas.');
            return;
        }

        $routeNameBase = $kebab; // ex.: feedback

        $routesBlock = <<<PHP

// === [AUTO] {$namespace} / {$name} ===
Route::middleware(['auth','acl:keep-{$kebab}'])->prefix('admin/{$kebab}')->group(function () {
    Route::get('/',                 [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'index'])->name('{$routeNameBase}.index');
    Route::get('/list',             [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'list'])->name('{$routeNameBase}.list');
    Route::get('/create',           [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'create'])->name('{$routeNameBase}.create');
    Route::post('/store',           [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'store'])->name('{$routeNameBase}.store');
    Route::get('/edit/{id}',        [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'edit'])->name('{$routeNameBase}.edit');
    Route::get('/find/{id}',        [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'find'])->name('{$routeNameBase}.find');
    Route::post('/update/{id}',     [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'update'])->name('{$routeNameBase}.update');
    Route::delete('/delete/{id}',   [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'delete'])->name('{$routeNameBase}.delete');
});
// === [/AUTO] {$namespace} / {$name} ===

PHP;

        $current = File::get($webPath);

        // Verificações simples para evitar duplicidade
        $alreadyHasByName = Str::contains($current, "name('{$routeNameBase}.index')");
        $alreadyHasByCtrl = Str::contains($current, "{$namespace}\\{$name}Controller");

        if ($alreadyHasByName || $alreadyHasByCtrl) {
            $this->warn("Rotas para {$namespace}/{$name} já parecem existir em routes/web.php. Não inseri novamente.");
            return;
        }

        File::append($webPath, $routesBlock);
        $this->info("Rotas adicionadas em routes/web.php para {$namespace}/{$name}.");
    }
}
