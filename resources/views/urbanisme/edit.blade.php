@extends('layouts.app')

@section('title', 'Modifier la Demande d\'Urbanisme')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Modifier la Demande d\'Urbanisme
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('urbanisme.update', $urbanismeRequest) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre de la demande *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $urbanismeRequest->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description détaillée *</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $urbanismeRequest->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Changer la photo</label>
                        <input class="form-control" type="file" id="photo" name="photo">
                        @error('photo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if ($urbanismeRequest->photo_path)
                            <div class="mt-3">
                                <p>Photo actuelle :</p>
                                <img src="{{ asset('storage/' . $urbanismeRequest->photo_path) }}" class="img-thumbnail" width="200" alt="Photo actuelle">
                            </div>
                        @endif
                    </div>

                    <hr>

                    <h5 class="mb-3">Coordonnées GPS (Optionnel)</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $urbanismeRequest->latitude) }}" placeholder="Ex: 4.0511">
                            @error('latitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $urbanismeRequest->longitude) }}" placeholder="Ex: 9.7679">
                            @error('longitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('urbanisme.show', $urbanismeRequest) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
