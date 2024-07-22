<div class="sidebar">
    <div class="d-flex gap-2 align-items-center">
        <img src="{{asset('img/logo_sena.png')}}" style="width: 80px; height: 80px;">
        <h5 class="mt-3 fw-bold" style="color: #fff">DTSENA</h5>
    </div>
    <a href="/panel"><i class="bi bi-house"></i> Home</a>
    @if(Auth::check())<a href="/panel/mis-canales/{{Auth::user()->id}}"><i class="bi bi-database-up"></i> Mis Canales</a>@endif
    <a href="#"><i class="bi bi-bar-chart"></i> Reportes</a>
    <a href="#"><i class="bi bi-info-circle"></i> Ayuda</a>
    @if (!Auth::check())
    <a href="/login"><i class="bi bi-box-arrow-right"></i> Iniciar sesión</a>
    @endif
    @if (Auth::check())
    <form action="/logout" method="post">
        @csrf
        <button><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
    </form>
    @endif

</div>
