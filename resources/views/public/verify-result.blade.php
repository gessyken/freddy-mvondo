@extends('layouts.app')

@section('title', 'Résultat de Vérification - ' . $civilAct->reference_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header text-center bg-success text-white">
                <h4 class="mb-0">
                    <i class="bi bi-check-circle"></i> Acte Valide
                </h4>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <i class="bi bi-shield-check"></i>
                    <strong>Cet acte d'état civil est authentique et valide.</strong>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Numéro de référence:</strong><br>
                        <code class="fs-5">{{ $civilAct->reference_number }}</code>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Type d'acte:</strong><br>
                        {{ $civilAct->type_label }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Statut:</strong><br>
                        <span class="badge bg-success fs-6">{{ $civilAct->status_label }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Validé le:</strong><br>
                        {{ $civilAct->validated_at ? $civilAct->validated_at->format('d/m/Y à H:i') : 'Non disponible' }}
                    </div>
                </div>

                <hr>

                <h5>Informations de l'acte:</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @foreach($civilAct->data as $key => $value)
                            <tr>
                                <td class="fw-bold">{{ ucfirst(str_replace('_', ' ', $key)) }}:</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                @if($civilAct->pdf_path)
                    <div class="text-center mt-4">
                        <a href="{{ route('public.download-act', $civilAct) }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-download"></i> Télécharger l'acte PDF
                        </a>
                    </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('public.verify') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Vérifier un autre acte
                    </a>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="card mt-4">
            <div class="card-body">
                <h5><i class="bi bi-shield-exclamation"></i> Avertissement de sécurité</h5>
                <p class="mb-0 text-muted">
                    Cette vérification confirme l'authenticité de l'acte au moment de la consultation. 
                    Pour toute question ou réclamation, contactez l'administration compétente.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
