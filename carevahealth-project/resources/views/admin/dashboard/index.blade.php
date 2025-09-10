@extends('admin.layouts.app')
@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Card Border Shadow -->
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="icon-base ti tabler-truck icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $clientsCount }}</h4>
                        </div>
                        <p class="mb-1">Total Clients</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">{{ $newClientsLast30 }}+</span>
                            <small class="text-body-secondary">new in last 30 days</small>
                        </p>
                    </div>
                </div>


            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="icon-base ti tabler-alert-triangle icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $employeesCount }}</h4>
                        </div>
                        <p class="mb-1">Total Employees</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">{{ $newEmployeesLast30 }}+</span>
                            <small class="text-body-secondary">new in last 30 days</small>
                        </p>
                    </div>
                </div>
            </div>
<div class="col-lg-3 col-sm-6">
    <div class="card card-border-shadow-success h-100">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <div class="avatar me-4 position-relative">
                    <span class="avatar-initial rounded bg-label-success pulse-icon">
                        <i class="ti ti-login rounded icon-12px"></i>
                    </span>
                </div>
                <h4 class="mb-0" id="checkedInCount">0</h4>
            </div>
            <p class="mb-1">Today Live</p>
        </div>
    </div>
</div>


{{-- ✅ CSS for Wave Effect --}}
<style>
.pulse-icon {
    position: relative;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    overflow: visible;
}

.pulse-icon::after {
    content: "";
    position: absolute;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid currentColor;
    animation: pulseWave 1.5s infinite;
    opacity: 0.6;
}

@keyframes pulseWave {
    0% {
        transform: scale(0.6);
        opacity: 0.8;
    }
    70% {
        transform: scale(1.3);
        opacity: 0;
    }
    100% {
        transform: scale(0.6);
        opacity: 0;
    }
}
</style>


{{-- ✅ Script --}}
<script>
    function loadAttendanceStats() {
        fetch("{{ route('attendance.stats') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('checkedInCount').innerText = data.checkedIn;
            })
            .catch(error => console.error('Error fetching stats:', error));
    }

    loadAttendanceStats();

    setInterval(loadAttendanceStats, 1000);
</script>

            <!--/ Card Border Shadow -->
            <!-- Vehicles overview -->
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Vehicles Overview</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill p-2 border-0 me-n1 waves-effect"
                                type="button" id="vehiclesOverview" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="vehiclesOverview">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-none d-lg-flex vehicles-progress-labels mb-6">
                            <div class="vehicles-progress-label on-the-way-text" style="width: 39.7%">On the way</div>
                            <div class="vehicles-progress-label unloading-text" style="width: 28.3%">Unloading</div>
                            <div class="vehicles-progress-label loading-text" style="width: 17.4%">Loading</div>
                            <div class="vehicles-progress-label waiting-text text-nowrap" style="width: 14.6%">Waiting</div>
                        </div>
                        <div class="vehicles-overview-progress progress rounded-3 mb-3 bg-transparent overflow-hidden"
                            style="height: 46px">
                            <div class="progress-bar fw-medium text-start shadow-none bg-lighter text-heading px-4 rounded-0"
                                role="progressbar" style="width: 39.7%" aria-valuenow="39.7" aria-valuemin="0"
                                aria-valuemax="100">
                                39.7%
                            </div>
                            <div class="progress-bar fw-medium text-start shadow-none bg-primary px-4" role="progressbar"
                                style="width: 28.3%" aria-valuenow="28.3" aria-valuemin="0" aria-valuemax="100">
                                28.3%
                            </div>
                            <div class="progress-bar fw-medium text-start shadow-none text-bg-info px-2 px-sm-4"
                                role="progressbar" style="width: 17.4%" aria-valuenow="17.4" aria-valuemin="0"
                                aria-valuemax="100">
                                17.4%
                            </div>
                            <div class="progress-bar fw-medium text-start shadow-none snackbar text-paper px-1 px-sm-3 rounded-0 px-lg-4"
                                role="progressbar" style="width: 14.6%" aria-valuenow="14.6" aria-valuemin="0"
                                aria-valuemax="100">
                                14.6%
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-border-top-0 table-border-bottom-0">
                                <tbody>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i class="icon-base ti tabler-car icon-lg text-heading"></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">On the way</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">2hr 10min</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span>39.7%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i
                                                        class="icon-base ti tabler-circle-arrow-down icon-lg text-heading"></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">Unloading</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">3hr 15min</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span>28.3%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i
                                                        class="icon-base ti tabler-circle-arrow-up icon-lg text-heading"></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">Loading</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">1hr 24min</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span>17.4%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i class="icon-base ti tabler-clock icon-lg text-heading"></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">Waiting</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">5hr 19min</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span>14.6%</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Vehicles overview -->

            <!-- Shipment statistics-->
            <div class="col-xxl-6 col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Shipment statistics</h5>
                            <p class="card-subtitle">Total number of deliveries 23.8k</p>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-label-primary waves-effect">January</button>
                            <button type="button"
                                class="btn btn-label-primary dropdown-toggle dropdown-toggle-split waves-effect"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">January</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">February</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">March</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">April</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">May</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">June</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">July</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">August</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">September</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">October</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">November</a></li>
                                <li><a class="dropdown-item waves-effect" href="javascript:void(0);">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="shipmentStatisticsChart" style="min-height: 320px;">
                            <div id="apexchartsb4b5cvfe" class="apexcharts-canvas apexchartsb4b5cvfe apexcharts-theme-"
                                style="width: 551px; height: 320px;"><svg xmlns="http://www.w3.org/2000/svg"
                                    version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" class="apexcharts-svg"
                                    xmlns:data="ApexChartsNS" transform="translate(0, 0)" width="551" height="320">
                                    <foreignObject x="0" y="0" width="551" height="320">
                                        <div class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom"
                                            xmlns="http://www.w3.org/1999/xhtml"
                                            style="height: 40px; right: 0px; position: absolute; left: 0px; top: 287px;">
                                            <div class="apexcharts-legend-series" rel="1" seriesname="Shipment"
                                                data:collapsed="false" style="margin: 0px 10px;"><span
                                                    class="apexcharts-legend-marker" rel="1"
                                                    data:collapsed="false"
                                                    style="height: 8px; width: 8px; left: -3px; top: 0px;"><svg
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%"
                                                        height="100%">
                                                        <path d="M 0, 0
                           m -4, 0
                           a 4,4 0 1,0 8,0
                           a 4,4 0 1,0 -8,0" fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="0"
                                                            stroke-dasharray="0" cx="0" cy="0"
                                                            shape="circle"
                                                            class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                            style="transform: translate(50%, 50%);"></path>
                                                    </svg></span><span class="apexcharts-legend-text" rel="1" i="0"
                                                    data:default-text="Shipment" data:collapsed="false"
                                                    style="color: var(--bs-heading-color); font-size: 13px; font-weight: 400; font-family: var(--bs-font-family-base);">Shipment</span>
                                            </div>
                                            <div class="apexcharts-legend-series" rel="2" seriesname="Delivery"
                                                data:collapsed="false" style="margin: 0px 10px;"><span
                                                    class="apexcharts-legend-marker" rel="2"
                                                    data:collapsed="false"
                                                    style="height: 8px; width: 8px; left: -3px; top: 0px;"><svg
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%"
                                                        height="100%">
                                                        <path d="M 0, 0
                           m -4, 0
                           a 4,4 0 1,0 8,0
                           a 4,4 0 1,0 -8,0" fill="var(--bs-primary)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="0"
                                                            stroke-dasharray="0" cx="0" cy="0"
                                                            shape="circle"
                                                            class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                            style="transform: translate(50%, 50%);"></path>
                                                    </svg></span><span class="apexcharts-legend-text" rel="2" i="1"
                                                    data:default-text="Delivery" data:collapsed="false"
                                                    style="color: var(--bs-heading-color); font-size: 13px; font-weight: 400; font-family: var(--bs-font-family-base);">Delivery</span>
                                            </div>
                                        </div>
                                        <style type="text/css">
                                            .apexcharts-flip-y {
                                                transform: scaleY(-1) translateY(-100%);
                                                transform-origin: top;
                                                transform-box: fill-box;
                                            }

                                            .apexcharts-flip-x {
                                                transform: scaleX(-1);
                                                transform-origin: center;
                                                transform-box: fill-box;
                                            }

                                            .apexcharts-legend {
                                                display: flex;
                                                overflow: auto;
                                                padding: 0 10px;
                                            }

                                            .apexcharts-legend.apexcharts-legend-group-horizontal {
                                                flex-direction: column;
                                            }

                                            .apexcharts-legend-group {
                                                display: flex;
                                            }

                                            .apexcharts-legend-group-vertical {
                                                flex-direction: column-reverse;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom,
                                            .apexcharts-legend.apx-legend-position-top {
                                                flex-wrap: wrap
                                            }

                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                flex-direction: column;
                                                bottom: 0;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                justify-content: flex-start;
                                                align-items: flex-start;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                                justify-content: center;
                                                align-items: center;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                                justify-content: flex-end;
                                                align-items: flex-end;
                                            }

                                            .apexcharts-legend-series {
                                                cursor: pointer;
                                                line-height: normal;
                                                display: flex;
                                                align-items: center;
                                            }

                                            .apexcharts-legend-text {
                                                position: relative;
                                                font-size: 14px;
                                            }

                                            .apexcharts-legend-text *,
                                            .apexcharts-legend-marker * {
                                                pointer-events: none;
                                            }

                                            .apexcharts-legend-marker {
                                                position: relative;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                cursor: pointer;
                                                margin-right: 1px;
                                            }

                                            .apexcharts-legend-series.apexcharts-no-click {
                                                cursor: auto;
                                            }

                                            .apexcharts-legend .apexcharts-hidden-zero-series,
                                            .apexcharts-legend .apexcharts-hidden-null-series {
                                                display: none !important;
                                            }

                                            .apexcharts-inactive-legend {
                                                opacity: 0.45;
                                            }
                                        </style>
                                    </foreignObject>
                                    <rect width="0" height="0" x="0" y="0" rx="0" ry="0"
                                        opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                        fill="#fefefe"></rect>
                                    <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                    <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                    <g class="apexcharts-yaxis" rel="0"
                                        transform="translate(34.44096755981445, 0)">
                                        <g class="apexcharts-yaxis-texts-g"><text x="20" y="34.333333333333336"
                                                text-anchor="end" dominant-baseline="auto" font-size="13px"
                                                font-family="var(--bs-font-family-base)" font-weight="400"
                                                fill="var(--bs-secondary-color)"
                                                class="apexcharts-text apexcharts-yaxis-label "
                                                style="font-family: var(--bs-font-family-base);">
                                                <tspan>50%</tspan>
                                                <title>50%</title>
                                            </text><text x="20" y="88.5529334104856" text-anchor="end"
                                                dominant-baseline="auto" font-size="13px"
                                                font-family="var(--bs-font-family-base)" font-weight="400"
                                                fill="var(--bs-secondary-color)"
                                                class="apexcharts-text apexcharts-yaxis-label "
                                                style="font-family: var(--bs-font-family-base);">
                                                <tspan>37.5%</tspan>
                                                <title>37.5%</title>
                                            </text><text x="20" y="142.77253348763784" text-anchor="end"
                                                dominant-baseline="auto" font-size="13px"
                                                font-family="var(--bs-font-family-base)" font-weight="400"
                                                fill="var(--bs-secondary-color)"
                                                class="apexcharts-text apexcharts-yaxis-label "
                                                style="font-family: var(--bs-font-family-base);">
                                                <tspan>25%</tspan>
                                                <title>25%</title>
                                            </text><text x="20" y="196.9921335647901" text-anchor="end"
                                                dominant-baseline="auto" font-size="13px"
                                                font-family="var(--bs-font-family-base)" font-weight="400"
                                                fill="var(--bs-secondary-color)"
                                                class="apexcharts-text apexcharts-yaxis-label "
                                                style="font-family: var(--bs-font-family-base);">
                                                <tspan>12.5%</tspan>
                                                <title>12.5%</title>
                                            </text><text x="20" y="251.21173364194235" text-anchor="end"
                                                dominant-baseline="auto" font-size="13px"
                                                font-family="var(--bs-font-family-base)" font-weight="400"
                                                fill="var(--bs-secondary-color)"
                                                class="apexcharts-text apexcharts-yaxis-label "
                                                style="font-family: var(--bs-font-family-base);">
                                                <tspan>0%</tspan>
                                                <title>0%</title>
                                            </text></g>
                                    </g>
                                    <g class="apexcharts-inner apexcharts-graphical"
                                        transform="translate(79.79188712437947, 30)">
                                        <defs>
                                            <clipPath id="gridRectMaskb4b5cvfe">
                                                <rect width="429.8257478078206" height="216.878400308609" x="0" y="0"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectBarMaskb4b5cvfe">
                                                <rect width="467.5275869369506" height="223.878400308609"
                                                    x="-18.85091956456502" y="-3.5" rx="0" ry="0"
                                                    opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                    fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectMarkerMaskb4b5cvfe">
                                                <rect width="441.8257478078206" height="228.878400308609" x="-6" y="-6"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMaskb4b5cvfe"></clipPath>
                                            <clipPath id="nonForecastMaskb4b5cvfe"></clipPath>
                                        </defs>
                                        <line x1="0" y1="0" x2="0" y2="216.878400308609"
                                            stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt"
                                            class="apexcharts-xcrosshairs" x="0" y="0" width="1"
                                            height="216.878400308609" fill="#b1b9c4" filter="none" fill-opacity="0.9"
                                            stroke-width="1"></line>
                                        <g class="apexcharts-grid">
                                            <g class="apexcharts-gridlines-horizontal">
                                                <line x1="-15.350919564565022" y1="54.21960007715225"
                                                    x2="445.1766673723856" y2="54.21960007715225"
                                                    stroke="var(--bs-border-color)" stroke-dasharray="8"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line x1="-15.350919564565022" y1="108.4392001543045"
                                                    x2="445.1766673723856" y2="108.4392001543045"
                                                    stroke="var(--bs-border-color)" stroke-dasharray="8"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line x1="-15.350919564565022" y1="162.65880023145675"
                                                    x2="445.1766673723856" y2="162.65880023145675"
                                                    stroke="var(--bs-border-color)" stroke-dasharray="8"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                            </g>
                                            <g class="apexcharts-gridlines-vertical"></g>
                                            <line x1="0" y1="216.878400308609" x2="429.8257478078206"
                                                y2="216.878400308609" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                            <line x1="0" y1="1" x2="0" y2="216.878400308609"
                                                stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                        </g>
                                        <g class="apexcharts-grid-borders">
                                            <line x1="-15.350919564565022" y1="0" x2="445.1766673723856"
                                                y2="0" stroke="var(--bs-border-color)" stroke-dasharray="8"
                                                stroke-linecap="butt" class="apexcharts-gridline"></line>
                                            <line x1="-15.350919564565022" y1="216.878400308609" x2="445.1766673723856"
                                                y2="216.878400308609" stroke="var(--bs-border-color)"
                                                stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline">
                                            </line>
                                        </g>
                                        <g class="apexcharts-bar-series apexcharts-plot-series">
                                            <g class="apexcharts-series" rel="1" seriesName="Shipment"
                                                data:realIndex="0">
                                                <path
                                                    d="M -7.1637624634636765 212.879400308609 L -7.1637624634636765 56.051816074066174 C -7.1637624634636765 54.051816074066174 -5.1637624634636765 52.051816074066174 -3.1637624634636765 52.051816074066174 L 3.1637624634636765 52.051816074066174 C 5.1637624634636765 52.051816074066174 7.1637624634636765 54.051816074066174 7.1637624634636765 56.051816074066174 L 7.1637624634636765 212.879400308609 C 7.1637624634636765 214.879400308609 5.1637624634636765 216.879400308609 3.1637624634636765 216.879400308609 L -3.1637624634636765 216.879400308609 C -5.1637624634636765 216.879400308609 -7.1637624634636765 214.879400308609 -7.1637624634636765 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M -7.1637624634636765 212.879400308609 L -7.1637624634636765 56.051816074066174 C -7.1637624634636765 54.051816074066174 -5.1637624634636765 52.051816074066174 -3.1637624634636765 52.051816074066174 L 3.1637624634636765 52.051816074066174 C 5.1637624634636765 52.051816074066174 7.1637624634636765 54.051816074066174 7.1637624634636765 56.051816074066174 L 7.1637624634636765 212.879400308609 C 7.1637624634636765 214.879400308609 5.1637624634636765 216.879400308609 3.1637624634636765 216.879400308609 L -3.1637624634636765 216.879400308609 C -5.1637624634636765 216.879400308609 -7.1637624634636765 214.879400308609 -7.1637624634636765 212.879400308609 Z "
                                                    pathFrom="M -7.1637624634636765 216.879400308609 L -7.1637624634636765 216.879400308609 L 7.1637624634636765 216.879400308609 L 7.1637624634636765 216.879400308609 L 7.1637624634636765 216.879400308609 L 7.1637624634636765 216.879400308609 L 7.1637624634636765 216.879400308609 L -7.1637624634636765 216.879400308609 Z"
                                                    cy="52.05081607406618" cx="7.1637624634636765" j="0" val="38"
                                                    barHeight="164.82758423454283" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 40.5946539596275 212.879400308609 L 40.5946539596275 25.688840030860913 C 40.5946539596275 23.688840030860913 42.5946539596275 21.688840030860913 44.5946539596275 21.688840030860913 L 50.92217888655485 21.688840030860913 C 52.92217888655485 21.688840030860913 54.92217888655485 23.688840030860913 54.92217888655485 25.688840030860913 L 54.92217888655485 212.879400308609 C 54.92217888655485 214.879400308609 52.92217888655485 216.879400308609 50.92217888655485 216.879400308609 L 44.5946539596275 216.879400308609 C 42.5946539596275 216.879400308609 40.5946539596275 214.879400308609 40.5946539596275 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 40.5946539596275 212.879400308609 L 40.5946539596275 25.688840030860913 C 40.5946539596275 23.688840030860913 42.5946539596275 21.688840030860913 44.5946539596275 21.688840030860913 L 50.92217888655485 21.688840030860913 C 52.92217888655485 21.688840030860913 54.92217888655485 23.688840030860913 54.92217888655485 25.688840030860913 L 54.92217888655485 212.879400308609 C 54.92217888655485 214.879400308609 52.92217888655485 216.879400308609 50.92217888655485 216.879400308609 L 44.5946539596275 216.879400308609 C 42.5946539596275 216.879400308609 40.5946539596275 214.879400308609 40.5946539596275 212.879400308609 Z "
                                                    pathFrom="M 40.5946539596275 216.879400308609 L 40.5946539596275 216.879400308609 L 54.92217888655485 216.879400308609 L 54.92217888655485 216.879400308609 L 54.92217888655485 216.879400308609 L 54.92217888655485 216.879400308609 L 54.92217888655485 216.879400308609 L 40.5946539596275 216.879400308609 Z"
                                                    cy="21.68784003086091" cx="54.92217888655485" j="1" val="45"
                                                    barHeight="195.1905602777481" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 88.35307038271867 212.879400308609 L 88.35307038271867 77.73965610492706 C 88.35307038271867 75.73965610492706 90.35307038271867 73.73965610492706 92.35307038271867 73.73965610492706 L 98.68059530964602 73.73965610492706 C 100.68059530964602 73.73965610492706 102.68059530964602 75.73965610492706 102.68059530964602 77.73965610492706 L 102.68059530964602 212.879400308609 C 102.68059530964602 214.879400308609 100.68059530964602 216.879400308609 98.68059530964602 216.879400308609 L 92.35307038271867 216.879400308609 C 90.35307038271867 216.879400308609 88.35307038271867 214.879400308609 88.35307038271867 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 88.35307038271867 212.879400308609 L 88.35307038271867 77.73965610492706 C 88.35307038271867 75.73965610492706 90.35307038271867 73.73965610492706 92.35307038271867 73.73965610492706 L 98.68059530964602 73.73965610492706 C 100.68059530964602 73.73965610492706 102.68059530964602 75.73965610492706 102.68059530964602 77.73965610492706 L 102.68059530964602 212.879400308609 C 102.68059530964602 214.879400308609 100.68059530964602 216.879400308609 98.68059530964602 216.879400308609 L 92.35307038271867 216.879400308609 C 90.35307038271867 216.879400308609 88.35307038271867 214.879400308609 88.35307038271867 212.879400308609 Z "
                                                    pathFrom="M 88.35307038271867 216.879400308609 L 88.35307038271867 216.879400308609 L 102.68059530964602 216.879400308609 L 102.68059530964602 216.879400308609 L 102.68059530964602 216.879400308609 L 102.68059530964602 216.879400308609 L 102.68059530964602 216.879400308609 L 88.35307038271867 216.879400308609 Z"
                                                    cy="73.73865610492706" cx="102.68059530964602" j="2" val="33"
                                                    barHeight="143.13974420368194" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 136.11148680580985 212.879400308609 L 136.11148680580985 56.051816074066174 C 136.11148680580985 54.051816074066174 138.11148680580985 52.051816074066174 140.11148680580985 52.051816074066174 L 146.43901173273719 52.051816074066174 C 148.43901173273719 52.051816074066174 150.43901173273719 54.051816074066174 150.43901173273719 56.051816074066174 L 150.43901173273719 212.879400308609 C 150.43901173273719 214.879400308609 148.43901173273719 216.879400308609 146.43901173273719 216.879400308609 L 140.11148680580985 216.879400308609 C 138.11148680580985 216.879400308609 136.11148680580985 214.879400308609 136.11148680580985 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 136.11148680580985 212.879400308609 L 136.11148680580985 56.051816074066174 C 136.11148680580985 54.051816074066174 138.11148680580985 52.051816074066174 140.11148680580985 52.051816074066174 L 146.43901173273719 52.051816074066174 C 148.43901173273719 52.051816074066174 150.43901173273719 54.051816074066174 150.43901173273719 56.051816074066174 L 150.43901173273719 212.879400308609 C 150.43901173273719 214.879400308609 148.43901173273719 216.879400308609 146.43901173273719 216.879400308609 L 140.11148680580985 216.879400308609 C 138.11148680580985 216.879400308609 136.11148680580985 214.879400308609 136.11148680580985 212.879400308609 Z "
                                                    pathFrom="M 136.11148680580985 216.879400308609 L 136.11148680580985 216.879400308609 L 150.43901173273719 216.879400308609 L 150.43901173273719 216.879400308609 L 150.43901173273719 216.879400308609 L 150.43901173273719 216.879400308609 L 150.43901173273719 216.879400308609 L 136.11148680580985 216.879400308609 Z"
                                                    cy="52.05081607406618" cx="150.43901173273719" j="3" val="38"
                                                    barHeight="164.82758423454283" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 183.86990322890102 212.879400308609 L 183.86990322890102 82.07722411109924 C 183.86990322890102 80.07722411109924 185.86990322890102 78.07722411109924 187.86990322890102 78.07722411109924 L 194.1974281558284 78.07722411109924 C 196.1974281558284 78.07722411109924 198.1974281558284 80.07722411109924 198.1974281558284 82.07722411109924 L 198.1974281558284 212.879400308609 C 198.1974281558284 214.879400308609 196.1974281558284 216.879400308609 194.1974281558284 216.879400308609 L 187.86990322890102 216.879400308609 C 185.86990322890102 216.879400308609 183.86990322890102 214.879400308609 183.86990322890102 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 183.86990322890102 212.879400308609 L 183.86990322890102 82.07722411109924 C 183.86990322890102 80.07722411109924 185.86990322890102 78.07722411109924 187.86990322890102 78.07722411109924 L 194.1974281558284 78.07722411109924 C 196.1974281558284 78.07722411109924 198.1974281558284 80.07722411109924 198.1974281558284 82.07722411109924 L 198.1974281558284 212.879400308609 C 198.1974281558284 214.879400308609 196.1974281558284 216.879400308609 194.1974281558284 216.879400308609 L 187.86990322890102 216.879400308609 C 185.86990322890102 216.879400308609 183.86990322890102 214.879400308609 183.86990322890102 212.879400308609 Z "
                                                    pathFrom="M 183.86990322890102 216.879400308609 L 183.86990322890102 216.879400308609 L 198.1974281558284 216.879400308609 L 198.1974281558284 216.879400308609 L 198.1974281558284 216.879400308609 L 198.1974281558284 216.879400308609 L 198.1974281558284 216.879400308609 L 183.86990322890102 216.879400308609 Z"
                                                    cy="78.07622411109924" cx="198.1974281558284" j="4" val="32"
                                                    barHeight="138.80217619750977" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 231.6283196519922 212.879400308609 L 231.6283196519922 4.001 C 231.6283196519922 2.0010000000000003 233.6283196519922 0.001 235.6283196519922 0.001 L 241.95584457891954 0.001 C 243.95584457891954 0.001 245.95584457891954 2.001 245.95584457891954 4.001 L 245.95584457891954 212.879400308609 C 245.95584457891954 214.879400308609 243.95584457891954 216.879400308609 241.95584457891954 216.879400308609 L 235.6283196519922 216.879400308609 C 233.6283196519922 216.879400308609 231.6283196519922 214.879400308609 231.6283196519922 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 231.6283196519922 212.879400308609 L 231.6283196519922 4.001 C 231.6283196519922 2.0010000000000003 233.6283196519922 0.001 235.6283196519922 0.001 L 241.95584457891954 0.001 C 243.95584457891954 0.001 245.95584457891954 2.001 245.95584457891954 4.001 L 245.95584457891954 212.879400308609 C 245.95584457891954 214.879400308609 243.95584457891954 216.879400308609 241.95584457891954 216.879400308609 L 235.6283196519922 216.879400308609 C 233.6283196519922 216.879400308609 231.6283196519922 214.879400308609 231.6283196519922 212.879400308609 Z "
                                                    pathFrom="M 231.6283196519922 216.879400308609 L 231.6283196519922 216.879400308609 L 245.95584457891954 216.879400308609 L 245.95584457891954 216.879400308609 L 245.95584457891954 216.879400308609 L 245.95584457891954 216.879400308609 L 245.95584457891954 216.879400308609 L 231.6283196519922 216.879400308609 Z"
                                                    cy="0" cx="245.95584457891954" j="5" val="50"
                                                    barHeight="216.878400308609" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 279.3867360750834 212.879400308609 L 279.3867360750834 12.676136012344353 C 279.3867360750834 10.676136012344353 281.3867360750834 8.676136012344353 283.3867360750834 8.676136012344353 L 289.71426100201074 8.676136012344353 C 291.71426100201074 8.676136012344353 293.71426100201074 10.676136012344353 293.71426100201074 12.676136012344353 L 293.71426100201074 212.879400308609 C 293.71426100201074 214.879400308609 291.71426100201074 216.879400308609 289.71426100201074 216.879400308609 L 283.3867360750834 216.879400308609 C 281.3867360750834 216.879400308609 279.3867360750834 214.879400308609 279.3867360750834 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 279.3867360750834 212.879400308609 L 279.3867360750834 12.676136012344353 C 279.3867360750834 10.676136012344353 281.3867360750834 8.676136012344353 283.3867360750834 8.676136012344353 L 289.71426100201074 8.676136012344353 C 291.71426100201074 8.676136012344353 293.71426100201074 10.676136012344353 293.71426100201074 12.676136012344353 L 293.71426100201074 212.879400308609 C 293.71426100201074 214.879400308609 291.71426100201074 216.879400308609 289.71426100201074 216.879400308609 L 283.3867360750834 216.879400308609 C 281.3867360750834 216.879400308609 279.3867360750834 214.879400308609 279.3867360750834 212.879400308609 Z "
                                                    pathFrom="M 279.3867360750834 216.879400308609 L 279.3867360750834 216.879400308609 L 293.71426100201074 216.879400308609 L 293.71426100201074 216.879400308609 L 293.71426100201074 216.879400308609 L 293.71426100201074 216.879400308609 L 293.71426100201074 216.879400308609 L 279.3867360750834 216.879400308609 Z"
                                                    cy="8.675136012344353" cx="293.71426100201074" j="6" val="48"
                                                    barHeight="208.20326429626465" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 327.1451524981746 212.879400308609 L 327.1451524981746 47.37668006172179 C 327.1451524981746 45.37668006172179 329.1451524981746 43.37668006172179 331.1451524981746 43.37668006172179 L 337.47267742510195 43.37668006172179 C 339.47267742510195 43.37668006172179 341.47267742510195 45.37668006172179 341.47267742510195 47.37668006172179 L 341.47267742510195 212.879400308609 C 341.47267742510195 214.879400308609 339.47267742510195 216.879400308609 337.47267742510195 216.879400308609 L 331.1451524981746 216.879400308609 C 329.1451524981746 216.879400308609 327.1451524981746 214.879400308609 327.1451524981746 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 327.1451524981746 212.879400308609 L 327.1451524981746 47.37668006172179 C 327.1451524981746 45.37668006172179 329.1451524981746 43.37668006172179 331.1451524981746 43.37668006172179 L 337.47267742510195 43.37668006172179 C 339.47267742510195 43.37668006172179 341.47267742510195 45.37668006172179 341.47267742510195 47.37668006172179 L 341.47267742510195 212.879400308609 C 341.47267742510195 214.879400308609 339.47267742510195 216.879400308609 337.47267742510195 216.879400308609 L 331.1451524981746 216.879400308609 C 329.1451524981746 216.879400308609 327.1451524981746 214.879400308609 327.1451524981746 212.879400308609 Z "
                                                    pathFrom="M 327.1451524981746 216.879400308609 L 327.1451524981746 216.879400308609 L 341.47267742510195 216.879400308609 L 341.47267742510195 216.879400308609 L 341.47267742510195 216.879400308609 L 341.47267742510195 216.879400308609 L 341.47267742510195 216.879400308609 L 327.1451524981746 216.879400308609 Z"
                                                    cy="43.375680061721795" cx="341.47267742510195" j="7" val="40"
                                                    barHeight="173.5027202468872" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 374.90356892126573 212.879400308609 L 374.90356892126573 38.70154404937744 C 374.90356892126573 36.70154404937744 376.90356892126573 34.70154404937744 378.90356892126573 34.70154404937744 L 385.2310938481931 34.70154404937744 C 387.2310938481931 34.70154404937744 389.2310938481931 36.70154404937744 389.2310938481931 38.70154404937744 L 389.2310938481931 212.879400308609 C 389.2310938481931 214.879400308609 387.2310938481931 216.879400308609 385.2310938481931 216.879400308609 L 378.90356892126573 216.879400308609 C 376.90356892126573 216.879400308609 374.90356892126573 214.879400308609 374.90356892126573 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 374.90356892126573 212.879400308609 L 374.90356892126573 38.70154404937744 C 374.90356892126573 36.70154404937744 376.90356892126573 34.70154404937744 378.90356892126573 34.70154404937744 L 385.2310938481931 34.70154404937744 C 387.2310938481931 34.70154404937744 389.2310938481931 36.70154404937744 389.2310938481931 38.70154404937744 L 389.2310938481931 212.879400308609 C 389.2310938481931 214.879400308609 387.2310938481931 216.879400308609 385.2310938481931 216.879400308609 L 378.90356892126573 216.879400308609 C 376.90356892126573 216.879400308609 374.90356892126573 214.879400308609 374.90356892126573 212.879400308609 Z "
                                                    pathFrom="M 374.90356892126573 216.879400308609 L 374.90356892126573 216.879400308609 L 389.2310938481931 216.879400308609 L 389.2310938481931 216.879400308609 L 389.2310938481931 216.879400308609 L 389.2310938481931 216.879400308609 L 389.2310938481931 216.879400308609 L 374.90356892126573 216.879400308609 Z"
                                                    cy="34.70054404937744" cx="389.2310938481931" j="8" val="42"
                                                    barHeight="182.17785625923156" barWidth="14.327524926927353"></path>
                                                <path
                                                    d="M 422.66198534435694 212.879400308609 L 422.66198534435694 60.38938408023835 C 422.66198534435694 58.38938408023835 424.66198534435694 56.38938408023835 426.66198534435694 56.38938408023835 L 432.9895102712843 56.38938408023835 C 434.9895102712843 56.38938408023835 436.9895102712843 58.38938408023835 436.9895102712843 60.38938408023835 L 436.9895102712843 212.879400308609 C 436.9895102712843 214.879400308609 434.9895102712843 216.879400308609 432.9895102712843 216.879400308609 L 426.66198534435694 216.879400308609 C 424.66198534435694 216.879400308609 422.66198534435694 214.879400308609 422.66198534435694 212.879400308609 Z "
                                                    fill="var(--bs-warning)" fill-opacity="1" stroke="var(--bs-warning)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-bar-area undefined"
                                                    index="0" clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 422.66198534435694 212.879400308609 L 422.66198534435694 60.38938408023835 C 422.66198534435694 58.38938408023835 424.66198534435694 56.38938408023835 426.66198534435694 56.38938408023835 L 432.9895102712843 56.38938408023835 C 434.9895102712843 56.38938408023835 436.9895102712843 58.38938408023835 436.9895102712843 60.38938408023835 L 436.9895102712843 212.879400308609 C 436.9895102712843 214.879400308609 434.9895102712843 216.879400308609 432.9895102712843 216.879400308609 L 426.66198534435694 216.879400308609 C 424.66198534435694 216.879400308609 422.66198534435694 214.879400308609 422.66198534435694 212.879400308609 Z "
                                                    pathFrom="M 422.66198534435694 216.879400308609 L 422.66198534435694 216.879400308609 L 436.9895102712843 216.879400308609 L 436.9895102712843 216.879400308609 L 436.9895102712843 216.879400308609 L 436.9895102712843 216.879400308609 L 436.9895102712843 216.879400308609 L 422.66198534435694 216.879400308609 Z"
                                                    cy="56.38838408023835" cx="436.9895102712843" j="9" val="37"
                                                    barHeight="160.49001622837065" barWidth="14.327524926927353"></path>
                                                <g class="apexcharts-bar-goals-markers">
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)"></g>
                                                </g>
                                                <g class="apexcharts-bar-shadows apexcharts-hidden-element-shown"></g>
                                            </g>
                                        </g>
                                        <g class="apexcharts-line-series apexcharts-plot-series">
                                            <g class="apexcharts-series" zIndex="1" seriesName="Delivery"
                                                data:longestSeries="true" rel="1" data:realIndex="1">
                                                <path
                                                    d="M 0 117.11433616664887C 16.715445748081912 117.11433616664887 31.042970675009265 95.42649613578796 47.75841642309118 95.42649613578796C 64.4738621711731 95.42649613578796 78.80138709810043 117.11433616664887 95.51683284618235 117.11433616664887C 112.23227859426427 117.11433616664887 126.55980352119161 78.07622411109924 143.27524926927353 78.07622411109924C 159.99069501735545 78.07622411109924 174.3182199442828 95.42649613578796 191.0336656923647 95.42649613578796C 207.74911144044663 95.42649613578796 222.07663636737396 26.02540803703309 238.79208211545588 26.02540803703309C 255.5075278635378 26.02540803703309 269.83505279046517 78.07622411109924 286.55049853854706 78.07622411109924C 303.265944286629 78.07622411109924 317.5934692135563 52.05081607406618 334.30891496163827 52.05081607406618C 351.02436070972016 52.05081607406618 365.3518856366475 104.10163214813232 382.0673313847294 104.10163214813232C 398.78277713281136 104.10163214813232 413.1103020597387 69.40108809875488 429.8257478078206 69.40108809875488"
                                                    fill="none" fill-opacity="1" stroke="var(--bs-primary)"
                                                    stroke-opacity="1" stroke-linecap="round" stroke-width="3"
                                                    stroke-dasharray="0" class="apexcharts-line" index="1"
                                                    clip-path="url(#gridRectBarMaskb4b5cvfe)"
                                                    pathTo="M 0 117.11433616664887C 16.715445748081912 117.11433616664887 31.042970675009265 95.42649613578796 47.75841642309118 95.42649613578796C 64.4738621711731 95.42649613578796 78.80138709810043 117.11433616664887 95.51683284618235 117.11433616664887C 112.23227859426427 117.11433616664887 126.55980352119161 78.07622411109924 143.27524926927353 78.07622411109924C 159.99069501735545 78.07622411109924 174.3182199442828 95.42649613578796 191.0336656923647 95.42649613578796C 207.74911144044663 95.42649613578796 222.07663636737396 26.02540803703309 238.79208211545588 26.02540803703309C 255.5075278635378 26.02540803703309 269.83505279046517 78.07622411109924 286.55049853854706 78.07622411109924C 303.265944286629 78.07622411109924 317.5934692135563 52.05081607406618 334.30891496163827 52.05081607406618C 351.02436070972016 52.05081607406618 365.3518856366475 104.10163214813232 382.0673313847294 104.10163214813232C 398.78277713281136 104.10163214813232 413.1103020597387 69.40108809875488 429.8257478078206 69.40108809875488"
                                                    pathFrom="M 0 216.878400308609 L 0 216.878400308609 L 47.75841642309118 216.878400308609 L 95.51683284618235 216.878400308609 L 143.27524926927353 216.878400308609 L 191.0336656923647 216.878400308609 L 238.79208211545588 216.878400308609 L 286.55049853854706 216.878400308609 L 334.30891496163827 216.878400308609 L 382.0673313847294 216.878400308609 L 429.8257478078206 216.878400308609"
                                                    fill-rule="evenodd"></path>
                                                <g class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                                    data:realIndex="1">
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 0, 117.11433616664887
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="0" cy="117.11433616664887"
                                                            shape="circle" class="apexcharts-marker wr4h2ao3u"
                                                            rel="0" j="0" index="1" default-marker-size="5">
                                                        </path>
                                                        <path d="M 47.75841642309118, 95.42649613578796
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="47.75841642309118"
                                                            cy="95.42649613578796" shape="circle"
                                                            class="apexcharts-marker wo3ihwwwh" rel="1" j="1"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 95.51683284618235, 117.11433616664887
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="95.51683284618235"
                                                            cy="117.11433616664887" shape="circle"
                                                            class="apexcharts-marker wiaiehovcj" rel="2" j="2"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 143.27524926927353, 78.07622411109924
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="143.27524926927353"
                                                            cy="78.07622411109924" shape="circle"
                                                            class="apexcharts-marker ww5qv1glf" rel="3" j="3"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 191.0336656923647, 95.42649613578796
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="191.0336656923647"
                                                            cy="95.42649613578796" shape="circle"
                                                            class="apexcharts-marker w5b9tmv8p" rel="4" j="4"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 238.79208211545588, 26.02540803703309
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="238.79208211545588"
                                                            cy="26.02540803703309" shape="circle"
                                                            class="apexcharts-marker wuqn68vx8" rel="5" j="5"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 286.55049853854706, 78.07622411109924
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="286.55049853854706"
                                                            cy="78.07622411109924" shape="circle"
                                                            class="apexcharts-marker wu08s21yo" rel="6" j="6"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 334.30891496163827, 52.05081607406618
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="334.30891496163827"
                                                            cy="52.05081607406618" shape="circle"
                                                            class="apexcharts-marker w61y6rfdp" rel="7" j="7"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 382.0673313847294, 104.10163214813232
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="382.0673313847294"
                                                            cy="104.10163214813232" shape="circle"
                                                            class="apexcharts-marker wkn45qp21" rel="8" j="8"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                    <g class="apexcharts-series-markers"
                                                        clip-path="url(#gridRectMarkerMaskb4b5cvfe)">
                                                        <path d="M 429.8257478078206, 69.40108809875488
                           m -5, 0
                           a 5,5 0 1,0 10,0
                           a 5,5 0 1,0 -10,0" fill="var(--bs-white)" fill-opacity="1" stroke="var(--bs-primary)"
                                                            stroke-opacity="0.9" stroke-linecap="round" stroke-width="2"
                                                            stroke-dasharray="0" cx="429.8257478078206"
                                                            cy="69.40108809875488" shape="circle"
                                                            class="apexcharts-marker woc4yjwrni" rel="9" j="9"
                                                            index="1" default-marker-size="5"></path>
                                                    </g>
                                                </g>
                                            </g>
                                            <g class="apexcharts-datalabels apexcharts-hidden-element-shown"
                                                data:realIndex="0"></g>
                                            <g class="apexcharts-datalabels" data:realIndex="1"></g>
                                        </g>
                                        <line x1="-15.350919564565022" y1="0" x2="445.1766673723856"
                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                        <line x1="-15.350919564565022" y1="0" x2="445.1766673723856"
                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="0"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                        <g class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text x="0"
                                                    y="244.878400308609" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="10px" font-family="var(--bs-font-family-base)"
                                                    font-weight="400" fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>1 Jan</tspan>
                                                    <title>1 Jan</title>
                                                </text><text x="47.75841642309118" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>2 Jan</tspan>
                                                    <title>2 Jan</title>
                                                </text><text x="95.51683284618235" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>3 Jan</tspan>
                                                    <title>3 Jan</title>
                                                </text><text x="143.27524926927356" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>4 Jan</tspan>
                                                    <title>4 Jan</title>
                                                </text><text x="191.0336656923647" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>5 Jan</tspan>
                                                    <title>5 Jan</title>
                                                </text><text x="238.7920821154559" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>6 Jan</tspan>
                                                    <title>6 Jan</title>
                                                </text><text x="286.5504985385471" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>7 Jan</tspan>
                                                    <title>7 Jan</title>
                                                </text><text x="334.30891496163827" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>8 Jan</tspan>
                                                    <title>8 Jan</title>
                                                </text><text x="382.0673313847294" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>9 Jan</tspan>
                                                    <title>9 Jan</title>
                                                </text><text x="429.82574780782056" y="244.878400308609"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="10px"
                                                    font-family="var(--bs-font-family-base)" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: var(--bs-font-family-base);">
                                                    <tspan>10 Jan</tspan>
                                                    <title>10 Jan</title>
                                                </text></g>
                                        </g>
                                        <g class="apexcharts-yaxis-annotations"></g>
                                        <g class="apexcharts-xaxis-annotations"></g>
                                        <g class="apexcharts-point-annotations"></g>
                                    </g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-light">
                                    <div class="apexcharts-tooltip-title"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                        style="order: 1;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: var(--bs-warning);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-1"
                                        style="order: 2;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: var(--bs-primary);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
                                    <div class="apexcharts-xaxistooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                </div>
                                <div
                                    class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                    <div class="apexcharts-yaxistooltip-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Shipment statistics -->

            <!-- Delivery Performance -->
            <div class="col-xxl-4 col-lg-5">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1 me-2">Delivery Performance</h5>
                            <p class="card-subtitle">12% increase in this month</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill p-2 me-n1 waves-effect" type="button"
                                id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-dots-vertical icon-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-6 align-items-center">
                                <div class="avatar flex-shrink-0 me-4">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="icon-base ti tabler-package icon-26px"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">Packages in transit</h6>
                                        <small class="text-success mb-0">
                                            <i class="icon-base ti tabler-chevron-up me-1"></i>
                                            25.8%
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="text-body mb-0">10k</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6 align-items-center">
                                <div class="avatar flex-shrink-0 me-4">
                                    <span class="avatar-initial rounded bg-label-info"><i
                                            class="icon-base ti tabler-truck icon-28px"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">Packages out for delivery</h6>
                                        <small class="text-success mb-0">
                                            <i class="icon-base ti tabler-chevron-up me-1"></i>
                                            4.3%
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="text-body mb-0">5k</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6 align-items-center">
                                <div class="avatar flex-shrink-0 me-4">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="icon-base ti tabler-circle-check icon-26px"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">Packages delivered</h6>
                                        <small class="text-danger mb-0">
                                            <i class="icon-base ti tabler-chevron-down me-1"></i>
                                            12.5
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="text-body mb-0">15k</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6 align-items-center">
                                <div class="avatar flex-shrink-0 me-4">
                                    <span class="avatar-initial rounded bg-label-warning"><i
                                            class="icon-base ti tabler-percentage icon-26px"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">Delivery success rate</h6>
                                        <small class="text-success mb-0">
                                            <i class="icon-base ti tabler-chevron-up me-1"></i>
                                            35.6%
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="text-body mb-0">95%</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-6 align-items-center">
                                <div class="avatar flex-shrink-0 me-4">
                                    <span class="avatar-initial rounded bg-label-secondary"><i
                                            class="icon-base ti tabler-clock icon-26px"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">Average delivery time</h6>
                                        <small class="text-danger mb-0">
                                            <i class="icon-base ti tabler-chevron-down me-1"></i>
                                            2.15
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="text-body mb-0">2.5 Days</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-4">
                                    <span class="avatar-initial rounded bg-label-danger"><i
                                            class="icon-base ti tabler-users icon-26px"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">Customer satisfaction</h6>
                                        <small class="text-success mb-0">
                                            <i class="icon-base ti tabler-chevron-up me-1"></i>
                                            5.7%
                                        </small>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="text-body mb-0">4.5/5</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Delivery Performance -->

            <!-- Reasons for delivery exceptions -->
            <div class="col-xxl-4 col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill p-2 me-n1 waves-effect" type="button"
                                id="deliveryExceptions" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="deliveryExceptionsChart" style="min-height: 395px;">
                            <div id="apexcharts8djjty02" class="apexcharts-canvas apexcharts8djjty02 apexcharts-theme-"
                                style="width: 462px; height: 395px;"><svg xmlns="http://www.w3.org/2000/svg"
                                    version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" class="apexcharts-svg"
                                    xmlns:data="ApexChartsNS" transform="translate(0, 0)" width="462"
                                    height="395">
                                    <foreignObject x="0" y="0" width="462" height="395">
                                        <div class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom"
                                            xmlns="http://www.w3.org/1999/xhtml"
                                            style="right: 0px; position: absolute; left: 0px; top: 337px; max-height: 195.5px;">
                                            <div class="apexcharts-legend-series" rel="1"
                                                seriesname="Incorrectxaddress" data:collapsed="false"
                                                style="margin: 8px 15px;"><span class="apexcharts-legend-marker"
                                                    rel="1" data:collapsed="false"
                                                    style="height: 16px; width: 16px; left: -3px; top: 0px;"><svg
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%"
                                                        height="100%">
                                                        <path d="M 0, 0
                           m -7, 0
                           a 7,7 0 1,0 14,0
                           a 7,7 0 1,0 -14,0" fill="var(--bs-success)" fill-opacity="1" stroke="#ffffff"
                                                            stroke-opacity="0.9" stroke-linecap="butt"
                                                            stroke-width="1" stroke-dasharray="0" cx="0"
                                                            cy="0" shape="circle"
                                                            class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                            style="transform: translate(50%, 50%);"></path>
                                                    </svg></span><span class="apexcharts-legend-text" rel="1"
                                                    i="0" data:default-text="Incorrect%20address" data:collapsed="false"
                                                    style="color: var(--bs-heading-color); font-size: 13px; font-weight: 400; font-family: var(--bs-font-family-base);">Incorrect
                                                    address</span></div>
                                            <div class="apexcharts-legend-series" rel="2"
                                                seriesname="Weatherxconditions" data:collapsed="false"
                                                style="margin: 8px 15px;"><span class="apexcharts-legend-marker"
                                                    rel="2" data:collapsed="false"
                                                    style="height: 16px; width: 16px; left: -3px; top: 0px;"><svg
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%"
                                                        height="100%">
                                                        <path d="M 0, 0
                           m -7, 0
                           a 7,7 0 1,0 14,0
                           a 7,7 0 1,0 -14,0" fill="color-mix(in sRGB, var(--bs-success) 80%, var(--bs-paper-bg))"
                                                            fill-opacity="1" stroke="#ffffff" stroke-opacity="0.9"
                                                            stroke-linecap="butt" stroke-width="1"
                                                            stroke-dasharray="0" cx="0" cy="0"
                                                            shape="circle"
                                                            class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                            style="transform: translate(50%, 50%);"></path>
                                                    </svg></span><span class="apexcharts-legend-text" rel="2"
                                                    i="1" data:default-text="Weather%20conditions"
                                                    data:collapsed="false"
                                                    style="color: var(--bs-heading-color); font-size: 13px; font-weight: 400; font-family: var(--bs-font-family-base);">Weather
                                                    conditions</span></div>
                                            <div class="apexcharts-legend-series" rel="3"
                                                seriesname="FederalxHolidays" data:collapsed="false"
                                                style="margin: 8px 15px;"><span class="apexcharts-legend-marker"
                                                    rel="3" data:collapsed="false"
                                                    style="height: 16px; width: 16px; left: -3px; top: 0px;"><svg
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%"
                                                        height="100%">
                                                        <path d="M 0, 0
                           m -7, 0
                           a 7,7 0 1,0 14,0
                           a 7,7 0 1,0 -14,0" fill="color-mix(in sRGB, var(--bs-success) 60%, var(--bs-paper-bg))"
                                                            fill-opacity="1" stroke="#ffffff" stroke-opacity="0.9"
                                                            stroke-linecap="butt" stroke-width="1"
                                                            stroke-dasharray="0" cx="0" cy="0"
                                                            shape="circle"
                                                            class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                            style="transform: translate(50%, 50%);"></path>
                                                    </svg></span><span class="apexcharts-legend-text" rel="3"
                                                    i="2" data:default-text="Federal%20Holidays" data:collapsed="false"
                                                    style="color: var(--bs-heading-color); font-size: 13px; font-weight: 400; font-family: var(--bs-font-family-base);">Federal
                                                    Holidays</span></div>
                                            <div class="apexcharts-legend-series" rel="4"
                                                seriesname="Damagexduringxtransit" data:collapsed="false"
                                                style="margin: 8px 15px;"><span class="apexcharts-legend-marker"
                                                    rel="4" data:collapsed="false"
                                                    style="height: 16px; width: 16px; left: -3px; top: 0px;"><svg
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%"
                                                        height="100%">
                                                        <path d="M 0, 0
                           m -7, 0
                           a 7,7 0 1,0 14,0
                           a 7,7 0 1,0 -14,0" fill="color-mix(in sRGB, var(--bs-success) 40%, var(--bs-paper-bg))"
                                                            fill-opacity="1" stroke="#ffffff" stroke-opacity="0.9"
                                                            stroke-linecap="butt" stroke-width="1"
                                                            stroke-dasharray="0" cx="0" cy="0"
                                                            shape="circle"
                                                            class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                            style="transform: translate(50%, 50%);"></path>
                                                    </svg></span><span class="apexcharts-legend-text" rel="4"
                                                    i="3" data:default-text="Damage%20during%20transit"
                                                    data:collapsed="false"
                                                    style="color: var(--bs-heading-color); font-size: 13px; font-weight: 400; font-family: var(--bs-font-family-base);">Damage
                                                    during transit</span></div>
                                        </div>
                                        <style type="text/css">
                                            .apexcharts-flip-y {
                                                transform: scaleY(-1) translateY(-100%);
                                                transform-origin: top;
                                                transform-box: fill-box;
                                            }

                                            .apexcharts-flip-x {
                                                transform: scaleX(-1);
                                                transform-origin: center;
                                                transform-box: fill-box;
                                            }

                                            .apexcharts-legend {
                                                display: flex;
                                                overflow: auto;
                                                padding: 0 10px;
                                            }

                                            .apexcharts-legend.apexcharts-legend-group-horizontal {
                                                flex-direction: column;
                                            }

                                            .apexcharts-legend-group {
                                                display: flex;
                                            }

                                            .apexcharts-legend-group-vertical {
                                                flex-direction: column-reverse;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom,
                                            .apexcharts-legend.apx-legend-position-top {
                                                flex-wrap: wrap
                                            }

                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                flex-direction: column;
                                                bottom: 0;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                justify-content: flex-start;
                                                align-items: flex-start;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                                justify-content: center;
                                                align-items: center;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                                justify-content: flex-end;
                                                align-items: flex-end;
                                            }

                                            .apexcharts-legend-series {
                                                cursor: pointer;
                                                line-height: normal;
                                                display: flex;
                                                align-items: center;
                                            }

                                            .apexcharts-legend-text {
                                                position: relative;
                                                font-size: 14px;
                                            }

                                            .apexcharts-legend-text *,
                                            .apexcharts-legend-marker * {
                                                pointer-events: none;
                                            }

                                            .apexcharts-legend-marker {
                                                position: relative;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                cursor: pointer;
                                                margin-right: 1px;
                                            }

                                            .apexcharts-legend-series.apexcharts-no-click {
                                                cursor: auto;
                                            }

                                            .apexcharts-legend .apexcharts-hidden-zero-series,
                                            .apexcharts-legend .apexcharts-hidden-null-series {
                                                display: none !important;
                                            }

                                            .apexcharts-inactive-legend {
                                                opacity: 0.45;
                                            }
                                        </style>
                                    </foreignObject>
                                    <g class="apexcharts-inner apexcharts-graphical" transform="translate(0, 15)">
                                        <defs>
                                            <clipPath id="gridRectMask8djjty02">
                                                <rect width="462" height="302" x="0" y="0" rx="0"
                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectBarMask8djjty02">
                                                <rect width="466" height="306" x="-2" y="-2" rx="0"
                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectMarkerMask8djjty02">
                                                <rect width="462" height="302" x="0" y="0" rx="0"
                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMask8djjty02"></clipPath>
                                            <clipPath id="nonForecastMask8djjty02"></clipPath>
                                        </defs>
                                        <g class="apexcharts-pie">
                                            <g transform="translate(0, 0) scale(1)">
                                                <circle r="110.35414634146343" cx="231" cy="151"
                                                    fill="transparent"></circle>
                                                <g class="apexcharts-slices">
                                                    <g class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="Incorrectxaddress" rel="1"
                                                        data:realIndex="0">
                                                        <path
                                                            d="M 231 7.682926829268268 A 143.31707317073173 143.31707317073173 0 0 1 335.4736501153223 52.892712330805495 L 311.4447105887982 75.45738849472022 A 110.35414634146343 110.35414634146343 0 0 0 231 40.645853658536566 L 231 7.682926829268268 z "
                                                            fill="var(--bs-success)" fill-opacity="1" stroke="#ffffff"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="0"
                                                            stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-0"
                                                            index="0" j="0" data:angle="46.8" data:startAngle="0"
                                                            data:strokeWidth="0" data:value="13"
                                                            data:pathOrig="M 231 7.682926829268268 A 143.31707317073173 143.31707317073173 0 0 1 335.4736501153223 52.892712330805495 L 311.4447105887982 75.45738849472022 A 110.35414634146343 110.35414634146343 0 0 0 231 40.645853658536566 L 231 7.682926829268268 z ">
                                                        </path>
                                                    </g>
                                                    <g class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="Weatherxconditions" rel="2"
                                                        data:realIndex="1">
                                                        <path
                                                            d="M 335.4736501153223 52.892712330805495 A 143.31707317073173 143.31707317073173 0 0 1 329.10728766919453 255.4736501153223 L 306.54261150527975 231.4447105887982 A 110.35414634146343 110.35414634146343 0 0 0 311.4447105887982 75.45738849472022 L 335.4736501153223 52.892712330805495 z "
                                                            fill="color-mix(in sRGB, var(--bs-success) 80%, var(--bs-paper-bg))"
                                                            fill-opacity="1" stroke="#ffffff" stroke-opacity="1"
                                                            stroke-linecap="butt" stroke-width="0"
                                                            stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-1"
                                                            index="0" j="1" data:angle="90.00000000000001"
                                                            data:startAngle="46.8" data:strokeWidth="0"
                                                            data:value="25"
                                                            data:pathOrig="M 335.4736501153223 52.892712330805495 A 143.31707317073173 143.31707317073173 0 0 1 329.10728766919453 255.4736501153223 L 306.54261150527975 231.4447105887982 A 110.35414634146343 110.35414634146343 0 0 0 311.4447105887982 75.45738849472022 L 335.4736501153223 52.892712330805495 z ">
                                                        </path>
                                                    </g>
                                                    <g class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="FederalxHolidays" rel="3"
                                                        data:realIndex="2">
                                                        <path
                                                            d="M 329.10728766919453 255.4736501153223 A 143.31707317073173 143.31707317073173 0 0 1 146.76033798852262 266.9459477791998 L 166.13546025116244 240.27837978998383 A 110.35414634146343 110.35414634146343 0 0 0 306.54261150527975 231.4447105887982 L 329.10728766919453 255.4736501153223 z "
                                                            fill="color-mix(in sRGB, var(--bs-success) 60%, var(--bs-paper-bg))"
                                                            fill-opacity="1" stroke="#ffffff" stroke-opacity="1"
                                                            stroke-linecap="butt" stroke-width="0"
                                                            stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-2"
                                                            index="0" j="2" data:angle="79.19999999999999"
                                                            data:startAngle="136.8" data:strokeWidth="0"
                                                            data:value="22"
                                                            data:pathOrig="M 329.10728766919453 255.4736501153223 A 143.31707317073173 143.31707317073173 0 0 1 146.76033798852262 266.9459477791998 L 166.13546025116244 240.27837978998383 A 110.35414634146343 110.35414634146343 0 0 0 306.54261150527975 231.4447105887982 L 329.10728766919453 255.4736501153223 z ">
                                                        </path>
                                                    </g>
                                                    <g class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="Damagexduringxtransit" rel="4"
                                                        data:realIndex="3">
                                                        <path
                                                            d="M 146.76033798852262 266.9459477791998 A 143.31707317073173 143.31707317073173 0 0 1 230.97498645211544 7.682929012112112 L 230.9807395681289 40.64585533932632 A 110.35414634146343 110.35414634146343 0 0 0 166.13546025116244 240.27837978998383 L 146.76033798852262 266.9459477791998 z "
                                                            fill="color-mix(in sRGB, var(--bs-success) 40%, var(--bs-paper-bg))"
                                                            fill-opacity="1" stroke="#ffffff" stroke-opacity="1"
                                                            stroke-linecap="butt" stroke-width="0"
                                                            stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-3"
                                                            index="0" j="3" data:angle="144"
                                                            data:startAngle="216" data:strokeWidth="0" data:value="40"
                                                            data:pathOrig="M 146.76033798852262 266.9459477791998 A 143.31707317073173 143.31707317073173 0 0 1 230.97498645211544 7.682929012112112 L 230.9807395681289 40.64585533932632 A 110.35414634146343 110.35414634146343 0 0 0 166.13546025116244 240.27837978998383 L 146.76033798852262 266.9459477791998 z ">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                            <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)">
                                                <text x="231" y="181" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="15px" font-family="var(--bs-font-family-base)"
                                                    font-weight="400" fill="var(--bs-body-color)"
                                                    class="apexcharts-text apexcharts-datalabel-label"
                                                    style="font-family: var(--bs-font-family-base);">AVG.
                                                    Exceptions</text><text x="231" y="147" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="24px"
                                                    font-family="var(--bs-font-family-base)" font-weight="500"
                                                    fill="var(--bs-heading-color)"
                                                    class="apexcharts-text apexcharts-datalabel-value"
                                                    style="font-family: var(--bs-font-family-base);">30%</text>
                                            </g>
                                        </g>
                                        <line x1="0" y1="0" x2="462" y2="0"
                                            stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                        <line x1="0" y1="0" x2="462" y2="0"
                                            stroke="#b6b6b6" stroke-dasharray="0" stroke-width="0"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                    </g>
                                    <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-dark">
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                        style="order: 1;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: var(--bs-success);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-1"
                                        style="order: 2;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: color-mix(in sRGB, var(--bs-success) 80%, var(--bs-paper-bg));"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-2"
                                        style="order: 3;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: color-mix(in sRGB, var(--bs-success) 60%, var(--bs-paper-bg));"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-3"
                                        style="order: 4;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: color-mix(in sRGB, var(--bs-success) 40%, var(--bs-paper-bg));"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Reasons for delivery exceptions -->

            <!-- Orders by Countries -->
            <div class="col-xxl-4 col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Orders by Countries</h5>
                            <p class="card-subtitle">62 deliveries in progress</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill p-2 me-n1 waves-effect" type="button"
                                id="ordersCountries" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-dots-vertical icon-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountryTabs">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link active waves-effect" role="tab"
                                        data-bs-toggle="tab" data-bs-target="#navs-justified-new"
                                        aria-controls="navs-justified-new" aria-selected="true">
                                        New
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link waves-effect" role="tab"
                                        data-bs-toggle="tab" data-bs-target="#navs-justified-link-preparing"
                                        aria-controls="navs-justified-link-preparing" aria-selected="false"
                                        tabindex="-1">
                                        Preparing
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link waves-effect" role="tab"
                                        data-bs-toggle="tab" data-bs-target="#navs-justified-link-shipping"
                                        aria-controls="navs-justified-link-shipping" aria-selected="false"
                                        tabindex="-1">
                                        Shipping
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content border-0 mx-1">
                                <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class="icon-base ti tabler-circle-check"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Myrtle Ullrich</h6>
                                                <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class="icon-base ti tabler-map-pin"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Barry Schowalter</h6>
                                                <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-1 border-light border-dashed my-4"></div>
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class="icon-base ti tabler-circle-check"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Veronica Herman</h6>
                                                <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class="icon-base ti tabler-map-pin"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Helen Jacobs</h6>
                                                <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class="icon-base ti tabler-circle-check"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Barry Schowalter</h6>
                                                <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class="icon-base ti tabler-map-pin"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Myrtle Ullrich</h6>
                                                <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-1 border-light border-dashed my-4"></div>
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class="icon-base ti tabler-circle-check"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Veronica Herman</h6>
                                                <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class="icon-base ti tabler-map-pin"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Helen Jacobs</h6>
                                                <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class="icon-base ti tabler-circle-check"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Veronica Herman</h6>
                                                <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class="icon-base ti tabler-map-pin"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Barry Schowalter</h6>
                                                <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-1 border-light border-dashed my-4"></div>
                                    <ul class="timeline mb-0">
                                        <li class="timeline-item ps-6 border-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                                <i class="icon-base ti tabler-circle-check"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-success text-uppercase">sender</small>
                                                </div>
                                                <h6 class="my-50">Myrtle Ullrich</h6>
                                                <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                            </div>
                                        </li>
                                        <li class="timeline-item ps-6 border-transparent">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                                <i class="icon-base ti tabler-map-pin"></i>
                                            </span>
                                            <div class="timeline-event ps-1">
                                                <div class="timeline-header">
                                                    <small class="text-primary text-uppercase">Receiver</small>
                                                </div>
                                                <h6 class="my-50">Helen Jacobs</h6>
                                                <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Orders by Countries -->

            <!-- On route vehicles Table -->
            <div class="col-12 order-5">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">On route vehicles</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill p-2 me-n1 waves-effect" type="button"
                                id="routeVehicles" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-dots-vertical icon-md"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="routeVehicles">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable border-top">
                        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                            <div class="row mt-2 justify-content-between">
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto my-0">
                                </div>
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto my-0">
                                </div>
                            </div>
                            <div class="justify-content-between dt-layout-table mt-n2">
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                                    <table class="dt-route-vehicles table dataTable dtr-column" id="DataTables_Table_0"
                                        aria-describedby="DataTables_Table_0_info">
                                        <colgroup>
                                            <col data-dt-column="0">
                                            <col data-dt-column="1">
                                            <col data-dt-column="2">
                                            <col data-dt-column="3">
                                            <col data-dt-column="4">
                                            <col data-dt-column="5">
                                            <col data-dt-column="6">
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th data-dt-column="0" class="control dt-orderable-none"
                                                    rowspan="1" colspan="1" aria-label=""><span
                                                        class="dt-column-title"></span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="1" rowspan="1" colspan="1"
                                                    class="dt-select dt-orderable-none" aria-label=""><span
                                                        class="dt-column-title"></span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="2" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                    aria-sort="ascending"
                                                    aria-label="location: Activate to invert sorting" tabindex="0">
                                                    <span class="dt-column-title" role="button">location</span><span
                                                        class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="3" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc"
                                                    aria-label="starting route: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">starting
                                                        route</span><span class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc"
                                                    aria-label="ending route: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">ending route</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc"
                                                    aria-label="warnings: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">warnings</span><span
                                                        class="dt-column-order"></span></th>
                                                <th class="w-20 dt-orderable-asc dt-orderable-desc" data-dt-column="6"
                                                    rowspan="1" colspan="1"
                                                    aria-label="progress: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">progress</span><span
                                                        class="dt-column-order"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="7" class="dt-empty">Loading...</td>
                                            </tr>
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row mx-3 justify-content-between">
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto my-0">
                                    <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info"
                                        role="status">Showing 0 to 0 of 0 entries</div>
                                </div>
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto my-0">
                                    <div class="dt-paging">
                                        <nav aria-label="pagination"></nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ On route vehicles Table -->
        </div>
    </div>
    @endsection
