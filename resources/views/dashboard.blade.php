@extends('layouts.app', ['activePage' => '', 'titlePage' => __('')])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ __(' This is Our Dashboard Page') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label for=""  class="col-form-label"> Welcome To Our Dashboard Page</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-status">
                          <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                    <i class="material-icons">desktop_mac</i>
                            </div>
                            <div class="row">
                                <h3 class="card-title">Designation </h3>
                            </div>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  <a href="/designation"><h5>Designation<h5></a>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-status">
                          <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                    <i class="material-icons">people</i>
                            </div>
                            <div class="row">
                                <h3 class="card-title">Employees</h3>
                            </div>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  <a href="/employee"><h5>Employees<h5></a>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-status">
                          <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                    <i class="material-icons">business</i>
                            </div>
                            <div class="row">
                                <h3 class="card-title">Department</h3>
                            </div>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  <a href="/department"><h5>Department<h5></a>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-status">
                          <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                                    <i class="material-icons">card_giftcard</i>
                            </div>
                            <div class="row">
                                <h3 class="card-title">Holidays </h3>
                            </div>
                          </div>
                          <div class="card-footer">
                              <div class="stats">
                                  <a href="/holiday"><h5>Holidays<h5></a>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
       </div>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush