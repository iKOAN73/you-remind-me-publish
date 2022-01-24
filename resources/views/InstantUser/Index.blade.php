<x-yrm2>
  <div class="my-5">
    <h1 class="my-auto rem-h1">さあ、仕事に戻りましょう</h1>
    <p>
    <div id="app">
      <div class="text-left mt-5">
        <h4>TimerID {{ $user->id }}</h4>
        <h1 class="username">{{ $user->name }} タイマー</h1>
        <small>Instant ID: {{ $user->instant_id }}</small>
      </div>
      {{-- <ul class="list-group list-group-horizontal">
      <li class="list-group-item text-white-50">instant ID</li>
      <li class="list-group-item text-white-50">{{ $user->instant_id }}</li>
    </ul> --}}
      <ul class="list-group list-group-horizontal">
        <li class="list-group-item text-white-50">Registered time</li>
        <li class="list-group-item text-white-50">{{ $user->created_at }}</li>
      </ul>
      <ul class="list-group list-group-horizontal">
        <li class="list-group-item text-white-50">Latest Login</li>
        <li class="list-group-item text-white-50">{{ $user->updated_at }}</li>
      </ul>
    </div>
    </p>
  </div>
</x-yrm2>

<style>
  @media (min-width: 992px) {
    .rem-h1 {
      font-size: 2.7rem;
    }
  }

  @media (max-width: 767.98px) {
    .rem-h1 {
      font-size: 2rem;
    }
  }

  @media (max-width: 575.98px) {
    .rem-h1 {
      font-size: 1.35rem;
    }
  }
</style>