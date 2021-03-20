@extends('layouts.main')

@section('content')
    <form id="job-entry-form" action="{{ route('job-entry.submit') }}" method="POST" enctype="multipart/form-data">
        
        @csrf
        @method('POST')

        @include('components.bt_custom_input', [
            'label_text' => 'Nome',
            'icon' => 'fas fa-user',
            'type' => 'text',
            'name' => 'name',
            'placeholder' => 'seu nome',
            'title' => 'Nome'
        ])

        @include('components.bt_custom_input', [
            'label_text' => 'Email',
            'icon' => 'fas fa-envelope',
            'type' => 'email',
            'name' => 'email',
            'placeholder' => 'seu.email@exemplo.com',
            'title' => 'Email'
        ])

        @include('components.bt_custom_input', [
            'label_text' => 'Telefone',
            'icon' => 'fas fa-mobile',
            'type' => 'tel',
            'name' => 'phone_number',
            'placeholder' => '+__ __ _-____-____',
            'title' => 'Telefone'
        ])

        @include('components.bt_custom_input', [
            'label_text' => 'Cargo',
            'icon' => 'fas fa-suitcase',
            'type' => 'text',
            'name' => 'desired_role',
            'placeholder' => 'Gerente, Analista, Desenvolvedor...',
            'title' => 'Cargo'
        ])

        <div class="bt-form-group">
            <label for="">Escolaridade</label>
            <div class="bt-input-group">
                <div class="bt-input-group-icon-container">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <select required name="school_level" id="school_level" title="Escolaridade">
                    <option value="">Selecione uma opção</option>
                    @foreach ($school_levels as $sc)
                        <option value="{{ $sc }}">{{ $sc }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bt-form-group">
            <label for="additional_info">Observações</label>
            <textarea name="additional_info" id="additional_info" placeholder="Opcional" title="Observações"></textarea>
        </div>

        @include('components.file_input')

        <div class="bt-flex-end-container">
            <button type="submit" class="hover-transition bt-mw-100" title="Enviar">Enviar</button>
        </div>
        
    </form>
@endsection