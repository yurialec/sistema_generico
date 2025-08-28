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
    protected $description = 'Cria Controller, Service, Repository, Interface, Model, Views, Vue components, permissão e rotas (CRUD)';

    public function handle()
    {
        $namespace = Str::studly($this->argument('namespace')); // Ex: Admin
        $name = Str::studly($this->argument('name'));       // Ex: Feedback

        // Variantes
        $camel = Str::camel($name);                          // feedback
        $kebab = Str::kebab($name);                          // feedback
        $tableName = strtolower(Str::snake(Str::pluralStudly($name))); // feedbacks

        // Variáveis
        $varModel = $camel;
        $varService = $camel . 'Service';
        $varRepository = $camel . 'Repository';

        // Views: diretório e namespace
        $viewDir = strtolower($namespace . '/' . $kebab);    // admin/feedback
        $viewNamespace = strtolower($namespace . '.' . $kebab);    // admin.feedback

        // Blade layout: segue seu padrão para Admin
        $bladeLayout = (strtolower($namespace) === 'admin')
            ? 'admin.layouts.app_admin'
            : 'layouts.app';

        // Diretórios principais
        $dirs = [
            "app/Http/Controllers/{$namespace}",
            "app/Services/{$namespace}",
            "app/Repositories/{$namespace}",
            "app/Interfaces/{$namespace}",
            "app/Models/{$namespace}",
            "resources/views/{$viewDir}",
            "resources/js/Components/{$namespace}/{$name}", // onde ficarão os .vue
        ];
        foreach ($dirs as $dir) {
            if (!File::exists($dir))
                File::makeDirectory($dir, 0755, true);
        }

        // ================== Back-end templates ==================

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
                    // ajuste seus campos de busca aqui
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

        // ================== Views Blade ==================
        // Tags dos componentes Vue (kebab-case)
        $indexTag = "{$kebab}-index-component";
        $createTag = "{$kebab}-create-component";
        $editTag = "{$kebab}-edit-component";

        $bladeIndex = <<<BLADE
@extends('{$bladeLayout}')
@section('content')
    <{$indexTag}
        url-create="{{ route('{$kebab}.create') }}"
        url-edit="{{ route('{$kebab}.edit', ['id' => '_id']) }}">
    </{$indexTag}>
@endsection
BLADE;

        $bladeCreate = <<<BLADE
@extends('{$bladeLayout}')
@section('content')
    <{$createTag}
        url-index="{{ route('{$kebab}.index') }}">
    </{$createTag}>
@endsection
BLADE;

        $bladeEdit = <<<BLADE
@extends('{$bladeLayout}')
@section('content')
    <{$editTag}
        :id="'{{ \$id }}'"
        url-index="{{ route('{$kebab}.index') }}">
    </{$editTag}>
@endsection
BLADE;

        // ================== Vue Components (sem axios; apenas HTML/Bootstrap) ==================

        $vueIndex = <<<VUE
<template>
    <div class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">{$name}</h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter" placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12 text-md-end">
                    <a :href="urlCreate" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Coluna A</th>
                            <th>Coluna B</th>
                            <th>Coluna C</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder de linha (sem dados ainda) -->
                        <tr>
                            <td>1</td>
                            <td>—</td>
                            <td>—</td>
                            <td>—</td>
                            <td>
                                <a :href="urlEdit.replace('_id', 1)" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Sem dados (placeholder)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer py-2">
            <nav>
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li class="page-item disabled"><span class="page-link">Anterior</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item disabled"><span class="page-link">Próximo</span></li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        urlCreate: String,
        urlEdit: String,
    },
    data() {
        return {
            searchFilter: ''
        }
    }
}
</script>
VUE;

        $vueCreate = <<<VUE
<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar {$name}</h5>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Campo A</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Campo B</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Campo C</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm" disabled>Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <small class="text-muted d-block mt-3">* Formulário placeholder (sem integração)</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        urlIndex: String,
    },
    methods: {
        save() {
            // Placeholder: sem integração ainda
        }
    }
}
</script>
VUE;

        $vueEdit = <<<VUE
<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar {$name}</h5>
                <small class="text-muted">ID: {{ id }}</small>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Campo A</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Campo B</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Campo C</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm" disabled>Atualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <small class="text-muted d-block mt-3">* Formulário placeholder (sem integração)</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: [String, Number],
        urlIndex: String,
    },
    methods: {
        save() {
            // Placeholder: sem integração ainda
        }
    }
}
</script>
VUE;

        // ================== Grava arquivos ==================
        $files = [
            "app/Http/Controllers/{$namespace}/{$name}Controller.php" => $controller,
            "app/Services/{$namespace}/{$name}Service.php" => $service,
            "app/Repositories/{$namespace}/{$name}Repository.php" => $repository,
            "app/Interfaces/{$namespace}/{$name}RepositoryInterface.php" => $interface,
            "app/Models/{$namespace}/{$name}.php" => $model,
            "resources/views/{$viewDir}/index.blade.php" => $bladeIndex,
            "resources/views/{$viewDir}/create.blade.php" => $bladeCreate,
            "resources/views/{$viewDir}/edit.blade.php" => $bladeEdit,
            "resources/js/Components/{$namespace}/{$name}/{$name}IndexComponent.vue" => $vueIndex,
            "resources/js/Components/{$namespace}/{$name}/{$name}CreateComponent.vue" => $vueCreate,
            "resources/js/Components/{$namespace}/{$name}/{$name}EditComponent.vue" => $vueEdit,
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
        $this->line("→ Vue components criados em resources/js/Components/{$namespace}/{$name}/ (auto-registrados pelo seu app.js).");
    }

    protected function upsertPermission(string $kebab): void
    {
        try {
            $name = "keep-{$kebab}";
            $label = 'Manter ' . Str::headline($kebab);

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

    protected function appendRoutesToWeb(string $namespace, string $name, string $kebab): void
    {
        $webPath = base_path('routes/web.php');
        if (!File::exists($webPath)) {
            $this->warn('routes/web.php não encontrado. Pulei a etapa de rotas.');
            return;
        }

        $routesBlock = <<<PHP

// === [AUTO] {$namespace} / {$name} ===
Route::middleware(['auth','acl:keep-{$kebab}'])->prefix('admin/{$kebab}')->group(function () {
    Route::get('/',                 [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'index'])->name('{$kebab}.index');
    Route::get('/list',             [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'list'])->name('{$kebab}.list');
    Route::get('/create',           [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'create'])->name('{$kebab}.create');
    Route::post('/store',           [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'store'])->name('{$kebab}.store');
    Route::get('/edit/{id}',        [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'edit'])->name('{$kebab}.edit');
    Route::get('/find/{id}',        [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'find'])->name('{$kebab}.find');
    Route::post('/update/{id}',     [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'update'])->name('{$kebab}.update');
    Route::delete('/delete/{id}',   [App\\Http\\Controllers\\{$namespace}\\{$name}Controller::class, 'delete'])->name('{$kebab}.delete');
});
// === [/AUTO] {$namespace} / {$name} ===

PHP;

        $current = File::get($webPath);
        $alreadyHasByName = Str::contains($current, "name('{$kebab}.index')");
        $alreadyHasByCtrl = Str::contains($current, "{$namespace}\\{$name}Controller");

        if ($alreadyHasByName || $alreadyHasByCtrl) {
            $this->warn("Rotas para {$namespace}/{$name} já parecem existir em routes/web.php. Não inseri novamente.");
            return;
        }

        File::append($webPath, $routesBlock);
        $this->info("Rotas adicionadas em routes/web.php para {$namespace}/{$name}.");
    }
}
