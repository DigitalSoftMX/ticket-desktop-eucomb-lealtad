<div class="row mt-5">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body text-left">
                <h6 class="card-subtitle mt-0 mb-0 text-muted">Usuarios referidos</h6>
                <h3 class="title mb-0">{{number_format($user->user()->references()->count(),0)}}</h3>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body text-left">
                <h6 class="card-subtitle mt-0 mb-0 text-muted">Total de vales entregados</h6>
                <h3 class="title mb-0">{{number_format($user->user()->exchanges()->count(),0)}}</h3>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body text-left">
                <h6 class="card-subtitle mt-0 mb-0 text-muted">litros vendidos</h6>
                <h3 class="title mb-0">{{ number_format($user->user()->salesqrs()->sum('liters'), 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body text-left">
                <h6 class="card-subtitle mt-0 mb-0 text-muted">total de tickets escaneados</h6>
                <h3 class="title mt-0 mb-0">{{ number_format($user->user()->salesqrs()->count(), 0) }}</h3>
            </div>
        </div>
    </div>
</div>