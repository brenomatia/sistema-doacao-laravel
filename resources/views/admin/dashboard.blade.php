@extends('layouts.admin_menu')

@section('title', 'Painel')

@section('content')
<div class="container col-12">
    <div class="row">
        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-gradient-green text-white">
                <div class="card-body">
                    <div class="card-title text-uppercase text-white d-flex align-items-center justify-content-between mb-4">
                        <i class="fa-solid fa-clipboard-check fa-coins fa-lg me-2" style="margin-right: 10px;"></i>
                        <span>Vendas Hoje</span>
                    </div>
                    <hr style="border-top: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;">
                    <div class="text-center">
                        <h1 class="card-value text-white font-weight-bold mb-0" style="font-size: 32px;">1</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <div class="card-title text-uppercase text-white d-flex align-items-center justify-content-between mb-4">
                        <i class="fa-solid fa-receipt fa-lg me-2" style="margin-right: 10px;"></i>
                        <span>Tiquete Médio</span>
                    </div>
                    <hr style="border-top: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;">
                    <div class="text-center">
                        <h1 class="card-value text-white font-weight-bold mb-0" style="font-size: 32px;">R$ 1</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="card-title text-uppercase text-white d-flex align-items-center justify-content-between mb-4">
                        <i class="fa-solid fa-hand-holding-dollar fa-lg me-2" style="margin-right: 10px;"></i>
                        <span>Vendas bruto</span>
                    </div>
                    <hr style="border-top: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;">
                    <div class="text-center">
                        <h1 class="card-value text-white font-weight-bold mb-0" style="font-size: 32px;">R$ 1</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-4">
            <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="card-title text-uppercase text-white d-flex align-items-center justify-content-between mb-4">
                        <i class="fa-solid fa-dollar fa-lg me-2" style="margin-right: 10px;"></i>
                        <span>Lucro diario</span>
                    </div>
                    <hr style="border-top: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;">
                    <div class="text-center">
                        <h1 class="card-value text-white font-weight-bold mb-0" style="font-size: 32px;">R$ 1</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
