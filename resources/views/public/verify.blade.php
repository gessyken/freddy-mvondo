@extends('layouts.app')

@section('title', 'Vérification d\'Acte Civil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    <i class="bi bi-shield-check text-success"></i> Vérification d'Acte Civil
                </h4>
            </div>
            <div class="card-body">
                <p class="text-center text-muted mb-4">
                    Vérifiez l'authenticité d'un acte d'état civil en utilisant le numéro de référence ou le QR code.
                </p>

                <form method="GET" action="{{ route('public.verify') }}">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Numéro de référence *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   name="reference_number" 
                                   value="{{ $reference_number ?? '' }}"
                                   placeholder="Ex: ACT-2024-123456"
                                   required>
                        </div>
                        <div class="form-text">
                            Le numéro de référence se trouve en bas de l'acte ou peut être scanné via QR code.
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-search"></i> Vérifier l'acte
                        </button>
                    </div>
                </form>

                @if(isset($error))
                    <div class="alert alert-danger mt-4">
                        <i class="bi bi-exclamation-triangle"></i> {{ $error }}
                    </div>
                @endif

                <div class="text-center mt-4">
                    <p class="text-muted">
                        <i class="bi bi-info-circle"></i> 
                        Cette vérification est gratuite et accessible à tous.
                    </p>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="card mt-4">
            <div class="card-body">
                <h5><i class="bi bi-question-circle"></i> Comment utiliser cette fonctionnalité ?</h5>
                <ol class="mb-0">
                    <li>Entrez le numéro de référence de l'acte (format: ACT-YYYY-XXXXXX)</li>
                    <li>Cliquez sur "Vérifier l'acte"</li>
                    <li>Consultez les informations de l'acte si celui-ci est valide</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
