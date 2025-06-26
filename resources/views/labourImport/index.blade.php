@extends('layouts.template')

@section('content')
    <div class="container">
      <h2>ข้อมูลแรงงานจาก API</h2>

@if (!empty($labours) && is_array($labours))
    @foreach ($labours as $labour)
        <div class="card mb-3">
            <div class="card-header">
                ชื่อ: {{ $labour['nameth'] ?? '-' }} (ID: {{ $labour['id'] ?? '-' }})
            </div>
            <div class="card-body">
                <p><strong>อีเมล:</strong> {{ $labour['contract']['email'] ?? '-' }}</p>
                <p><strong>อายุ:</strong> {{ $labour['age'] ?? '-' }}</p>
                <p><strong>ทักษะ:</strong> {{ $labour['skill'] ?? '-' }}</p>
            </div>
        </div>
    @endforeach
@else
    <p class="text-danger">ไม่พบข้อมูลแรงงานจาก API</p>
@endif

    </div>
@endsection
