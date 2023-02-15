@extends('layouts.admin')

@section('content')
    @csrf
    <script type="text/javascript" src={{ asset('js/report_admin.js') }} defer></script>
    <div class="container">
        <div class="row">
            <h2 class="p-3 pb-5">Reports</h2>
        </div>
        <div class="row mb-5">
            <!--<div class="col-6"></div>
                        <div class="col-6 mb-3">
                            <form class="d-flex">
                                <input class="form-control me-sm-2" type="text" placeholder="Search">
                                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>-->
            <div class="accordion" id="accordion">
                @foreach ($reports as $report)
                    <div class="accordion-item" id="accordion-item-{{ $report->id }}">
                        <h2 class="accordion-header" id="heading{{ $report->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $report->id }}" aria-expanded="true"
                                aria-controls="collapse{{ $report->id }}">

                                <div class="col">
                                    @if ($report->resolved == false)
                                        <strong>Report ID: {{ $report->id }}</strong>
                                        @if (isset($report->id_review))
                                            <span class="badge bg-info ms-3">Review Report</span>
                                        @else
                                            <span class="badge bg-secondary ms-3">Other Report</span>
                                        @endif
                                        <span class="badge bg-warning ms-3" id="badge-change-{{ $report->id }}"
                                            style="display: none">Open</span>
                                    @elseif ($report->resolved == true)
                                        <strong>Report ID: {{ $report->id }}</strong>
                                        @if (isset($report->id_review))
                                            <span class="badge bg-info ms-3">Review Report</span>
                                        @else
                                            <span class="badge bg-secondary ms-3">Other Report</span>
                                        @endif
                                        <span class="badge bg-success ms-3" id="badge-change-{{ $report->id }}">Closed</span>
                                    @endif
                                    <br>
                                    <br>
                                    User ID: {{ $report->id_user }}
                                    <br>
                                    @if (isset($report->id_review))
                                        Review ID: {{ $report->id_review }}
                                    @endif
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $report->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $report->id }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-8">
                                        <strong>Description:</strong> {{ $report->description }}
                                        <br>
                                        @if (is_null($report['created_at']))
                                            <strong>Report Date:</strong> Not Available
                                        @else
                                            <strong>Report Date:</strong> {{ substr($report['created_at'], 0, 10) }}
                                        @endif
                                    </div>
                                    @if (Auth::guard('admin')->user()->role == 'Technician')
                                        <div class="col-3"></div>
                                        <div class="col-1">
                                            @if ($report->resolved == false)
                                                <div class="row">
                                                    <button class="btn btn-info btn-sm fa-solid fa-envelope change-report"
                                                        id="{{ $report->id }}">
                                                    </button>
                                                </div>
                                            @elseif ($report->resolved == true)
                                                <div class="row">
                                                    <button
                                                        class="btn btn-warning btn-sm fa-solid fa-envelope-open change-report"
                                                        id="{{ $report->id }}">
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="padding-top:1em;">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
@endsection
