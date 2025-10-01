@extends('layouts.app')

@section('title', 'Nouvelle Demande d\'Urbanisme')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-building"></i> Nouvelle Demande d\'Urbanisme
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('urbanisme.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre de la demande *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description détaillée *</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input class="form-control" type="file" id="photo" name="photo">
                        @error('photo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h5 class="mb-3">Coordonnées GPS (Optionnel)</h5>
                    <p class="text-muted">Si vous les connaissez, vous pouvez entrer les coordonnées GPS du lieu concerné.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Ex: 4.0511">
                            @error('latitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Ex: 9.7679">
                            @error('longitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('urbanisme.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Soumettre la demande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
