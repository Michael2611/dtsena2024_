<div class="sidebar">
    <div class="d-flex gap-2 align-items-center">
        <img src="{{asset('img/LOGO_DTSENA_BLANCO.png')}}" style="width: 150px; height: 150px; margin:auto; object-fit: cover">
    </div>
    <a href="/"><i class="bi bi-house"></i> Home</a>
    @if(Auth::check())<a href="/mis-canales/{{Auth::user()->id}}"><i class="bi bi-database-up"></i> Mis Canales</a>@endif
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
