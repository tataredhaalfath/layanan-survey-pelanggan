@extends('layouts.app')
@section('title', $title)
@section('content')
    <section id="hero">
        <div class="container">
            <div class="block block-survey">
                <div class="h2">Layanan Survey Kepuasan Pelanggan</div>
                <p>Sampaikan laporan survey anda secara langsung</p>
                <hr />
            </div>
        </div>
        <svg width="100%" height="160px" viewBox="0 0 1300 160" preserveAspectRatio="none" version="1.1"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g>
                <path
                    d="M1300,160 L-5.68434189e-14,160 L-5.68434189e-14,119 C423.103102,41.8480501 1096.33049,180.773108 1300,98 L1300,160 Z"
                    fill="#FFFFFF" fill-rule="nonzero"></path>
                <path
                    d="M129.77395,40.2373685 C292.925845,31.2149964 314.345174,146.772453 615.144273,151.135393 C915.94337,155.498333 1017.27057,40.8373289 1240.93447,40.8373289 C1262.89392,40.8373289 1282.20864,41.9705564 1299.18628,44.0144896 L1300,160 L-1.0658141e-14,160 L-1.0658141e-14,105 C31.4276111,70.4780448 73.5616946,43.3459311 129.77395,40.2373685 Z"
                    fill="#FFFFFF" fill-rule="nonzero" opacity="0.3"></path>
                <path
                    d="M69.77395,60.2373685 C232.925845,51.2149964 314.345174,146.772453 615.144273,151.135393 C915.94337,155.498333 1017.27057,0.837328936 1240.93447,0.837328936 C1263.91283,0.837328936 1283.59768,0.606916225 1300,1 L1300,160 L-1.70530257e-13,160 L-9.9475983e-14,74 C-9.9475983e-14,74 36.9912359,62.0502671 69.77395,60.2373685 Z"
                    fill="#FFFFFF" fill-rule="nonzero" opacity="0.3"></path>
                <path
                    d="M2.27373675e-13,68 C23.2194389,95.7701288 69.7555676,123.009338 207,125 C507.7991,129.36294 698.336099,22 922,22 C1047.38026,22 1198.02057,63.2171658 1300,101 L1300,160 L0,160 L2.27373675e-13,68 Z"
                    fill="#FFFFFF" fill-rule="nonzero" opacity="0.3"
                    transform="translate(650, 91) scale(-1, 1) translate(-650, -91) "></path>
            </g>
        </svg>
    </section>

    <section id="survey-box">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 mg-b-40">
                    <form action="POST" id="formSurvey" class="survey-form">
                        <div class="survey-form-box">
                            <div class="select-survey">Sampaikan Survey Anda</div>
                        </div>
                        <div class="survey-form-body">
                            {{-- INPUT --}}
                            <div class="survey-form-category">
                                <label for="name">Nama</label>
                                <input type="text" id="name" name="name" class="form-control mt-2"
                                    placeholder="masukan nama" required>
                            </div>
                            <div class="survey-form-category">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control mt-2"
                                    placeholder="masukan email" required>
                            </div>
                        </div>
                        <div class="survey-form-footer">
                            <div class="footer-right text-right">
                                <button class="btn btn-reset" type="reset" id="reset-survey" style="display:none"
                                    data-attach-loading="">LAPOR!</button>
                                <button class="btn btn-submit" type="submit" id="submit-survey"
                                    data-attach-loading="">LAPOR!</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('script')
    <!-- jQuery UI-->
    <script src="{{ asset('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <!-- Atlantis JS-->
    <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    {{-- custom alert --}}
    <script src="{{ asset('js/alert.js') }}"></script>
    <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
