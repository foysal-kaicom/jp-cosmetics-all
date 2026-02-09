<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>Cosmetics Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
      body{font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, 'Helvetica Neue', Arial; background: linear-gradient(135deg,#fff6fb 0%,#f3f7ff 100%);min-height:100vh;margin:0}
      .left-side{background-image:url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1400&q=80');background-size:cover;background-position:center;position:relative}
      .left-side::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,0.18),rgba(0,0,0,0.18))}
      .auth-card{width:100%;max-width:420px;background:rgba(255,255,255,0.98);box-shadow:0 10px 30px rgba(18,38,63,0.08);border-radius:12px;padding:28px}
      .brand{font-weight:700;color:#0d6efd}
      .divider{height:1px;background:linear-gradient(90deg,transparent,#e9eef8,transparent);margin:18px 0}
      @media (max-width:767px){
        .left-side{display:none}
        body{background:linear-gradient(135deg,#fff6fb 0%,#f3f7ff 100%)}
      }
    </style>
  </head>
  <body>
    <main class="container-fluid p-0" style="min-height:100vh;">
      <div class="row g-0 align-items-stretch" style="min-height:100vh;">
        <div class="col-md-6 left-side d-none d-md-block"></div>

        <div class=" col-12 col-md-6 d-flex align-items-center justify-content-center p-4">
          <section class="auth-card">
            <header class="text-center mb-3">
              <h1 class="h4 mb-1 brand">{{ env('APP_NAME') }}</h1>
              <p class="text-muted small">Sign in to your account</p>
            </header>

            <form action="{{ route('doLogin') }}" method="post" novalidate>
              @csrf

              @if ($errors->any())
                <div class="alert alert-danger py-2" role="alert">
                  <strong>There were some problems with your input.</strong>
                </div>
              @endif

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text bg-white border-end-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>
                  </span>
                  <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" placeholder="your@email.com" value="{{ old('email') }}">
                </div>
                @error('email')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text bg-white border-end-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M6 8V7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7V8H20C20.5523 8 21 8.44772 21 9V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V9C3 8.44772 3.44772 8 4 8H6ZM19 10H5V20H19V10ZM11 15.7324C10.4022 15.3866 10 14.7403 10 14C10 12.8954 10.8954 12 12 12C13.1046 12 14 12.8954 14 14C14 14.7403 13.5978 15.3866 13 15.7324V18H11V15.7324ZM8 8H16V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V8Z"></path></svg>
                  </span>
                  <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••">
                </div>
                @error('password')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label small text-muted" for="remember">Remember me</label>
                </div>
                <a href="/forgot-password" class="small">Forgot password?</a>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">Sign in</button>
              </div>

              <div class="divider"></div>

              <div class="text-center">
                <p class="small text-muted mb-2">Or continue with</p>
                <div class="d-flex justify-content-center gap-2">
                  <a class="btn btn-outline-secondary btn-sm" href="#">Google</a>
                  <a class="btn btn-outline-secondary btn-sm" href="#">Facebook</a>
                </div>
                <p class="mt-3 small">Don't have an account? <a href="/register">Create one</a></p>
              </div>
            </form>
          </section>
        </div>
      </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if (session('success'))
        <script>toastr.success("{{ session('success') }}");</script>
    @elseif (session('error'))
        <script>toastr.error("{{ session('error') }}");</script>
    @endif
  </body>
</html>
