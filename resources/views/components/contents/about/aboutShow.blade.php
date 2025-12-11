@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[]"
    :current="'Info'"
    />
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">

    <!-- Development Information -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació de Desenvolupament</h2>
            <p class="text-sm">
                Aquesta aplicació ha estat desenvolupada utilitzant <a href="https://laravel.com/" target="_blank" class="link link-primary">Laravel</a> i <a href="https://tailwindcss.com/" target="_blank" class="link link-primary">Tailwind CSS</a> amb <a href="https://daisyui.com/" target="_blank" class="link link-primary">DaisyUI</a>.           
            </p>
        </div>
    </div>

    <!-- Software Information -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Programari</h2>
            <div class="software pl-4">
                <ul class="space-y-2">
                    <li class="flex items-center justify-between">
                        <span>Laravel {{ $dependencies['laravel'] ?? 'N/A' }}:
                        <a href="https://github.com/laravel/laravel/blob/master/README.md" target="_blank" class="link link-primary">
                                MIT License
                            </a>
                        </span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>PHP {{ $dependencies['php'] ?? 'N/A' }}:
                        <a href="https://www.php.net/license/3_01.txt" target="_blank" class="link link-primary">
                                PHP License
                            </a>
                        </span>
                    </li>
                    @if(isset($dependencies['tailwindcss']))
                    <li class="flex items-center justify-between">
                        <span>Tailwind CSS {{ str_replace(['^', '~'], '', $dependencies['tailwindcss']) }}:
                        <a href="https://github.com/tailwindlabs/tailwindcss/blob/master/LICENSE" target="_blank" class="link link-primary">
                                MIT License
                            </a>
                        </span>
                    </li>
                    @endif
                    @if(isset($dependencies['daisyui']))
                    <li class="flex items-center justify-between">
                        <span>DaisyUI {{ str_replace(['^', '~'], '', $dependencies['daisyui']) }}:
                        <a href="https://github.com/saadeghi/daisyui/blob/master/LICENSE" target="_blank" class="link link-primary">
                                MIT License
                            </a>
                        </span>
                    </li>
                    @endif
                    @if(isset($dependencies['vite']))
                    <li class="flex items-center justify-between">
                        <span>Vite {{ str_replace(['^', '~'], '', $dependencies['vite']) }}:
                            <a href="https://github.com/vitejs/vite/blob/main/LICENSE" target="_blank" class="link link-primary">
                                MIT License
                            </a>
                        </span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>



</div>

@include('components.partials.mainToasts')
@endsection