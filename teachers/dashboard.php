<?php
    include('includes/header.php');
    include('includes/topbar.php');
    include('includes/sidebar.php');
    include('includes/modals.php');


        $grade_level_global2gb = (string) ($_SESSION['grade_level'] ?? '');
        $school_id = mysqli_real_escape_string($DB, (string) ($_SESSION['school_id'] ?? ''));
        $current_year = (int) date('Y');
        $requested_year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
        $selected_year = ($requested_year !== false && $requested_year >= 2000 && $requested_year <= $current_year)
            ? $requested_year
            : $current_year;
        $year_start = $selected_year . '-01-01 00:00:00';
        $next_year_start = ($selected_year + 1) . '-01-01 00:00:00';

        $dashboardDataErrors = [];
        $learners_result = mysqli_query($DB, "SELECT COUNT(*) AS total FROM students WHERE school_id = '$school_id' AND grade_level = '" . mysqli_real_escape_string($DB, $grade_level_global2gb) . "'");
        if (!$learners_result) {
            error_log('Teacher dashboard summary query failed: ' . mysqli_error($DB));
            $dashboardDataErrors[] = 'The dashboard summary could not be loaded.';
        }
        $learners_count = $learners_result ? (int) mysqli_fetch_assoc($learners_result)['total'] : 0;

?>
<style>
    .teacher-dashboard {
        --dashboard-ink: #172b4d;
        --dashboard-muted: #64748b;
        --dashboard-teal: #148a83;
        --dashboard-line: #e5ebf1;
    }
    .teacher-dashboard .dashboard-summary {
        position: relative;
        overflow: hidden;
        min-height: 145px;
        border: 0;
        border-radius: 18px;
        background: linear-gradient(120deg, #102c46 0%, #145b67 58%, #15938a 100%);
        box-shadow: 0 12px 30px rgba(16, 44, 70, .16);
        color: #fff;
        animation: dashboard-rise .55s ease both;
    }
    .teacher-dashboard .dashboard-summary .inner { position: relative; z-index: 1; }
    .teacher-dashboard .dashboard-summary h3 { color: #fff !important; font-size: 2.35rem; }
    .teacher-dashboard .dashboard-summary p { color: rgba(255,255,255,.82) !important; }
    .teacher-dashboard .dashboard-summary .icon {
        color: rgba(255,255,255,.17);
        font-size: 72px;
    }
    .teacher-dashboard .dashboard-summary .small-box-footer {
        background: rgba(0,0,0,.12);
        color: #fff !important;
    }
    .teacher-dashboard .dashboard-filter,
    .teacher-dashboard .trend-card {
        border: 1px solid var(--dashboard-line);
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(23, 43, 77, .06);
    }
    .teacher-dashboard .dashboard-filter { padding: 16px 18px; background: #fff; }
    .teacher-dashboard .trend-card {
        height: 100%;
        margin-bottom: 22px;
        overflow: hidden;
        animation: dashboard-rise .55s ease both;
    }
    .teacher-dashboard .trend-card .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--dashboard-line);
        background: #fff;
    }
    .teacher-dashboard .trend-card .card-title {
        margin: 0;
        color: var(--dashboard-ink);
        font-size: 1.08rem;
        font-weight: 700;
    }
    .teacher-dashboard .trend-card .card-title i { margin-right: 9px; color: var(--dashboard-teal); }
    .teacher-dashboard .term-badge {
        flex: 0 0 auto;
        padding: 6px 10px;
        border-radius: 999px;
        background: #e8f6f3;
        color: #126b67;
        font-size: .76rem;
        font-weight: 700;
    }
    .teacher-dashboard .trend-chart-wrap { position: relative; min-height: 300px; }
    .teacher-dashboard .trend-chart-wrap canvas { width: 100% !important; height: 300px !important; }
    .teacher-dashboard .trend-note { margin: 10px 0 0; color: var(--dashboard-muted); font-size: .82rem; }
    .teacher-dashboard .filter-label { color: var(--dashboard-ink); font-weight: 600; }
    @keyframes dashboard-rise {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 575.98px) {
        .teacher-dashboard .trend-card .card-header { align-items: flex-start; padding: 15px; }
        .teacher-dashboard .trend-card .card-title { font-size: .98rem; }
        .teacher-dashboard .trend-chart-wrap { min-height: 260px; }
        .teacher-dashboard .trend-chart-wrap canvas { height: 260px !important; }
        .teacher-dashboard .dashboard-filter .filter-actions { width: 100%; }
        .teacher-dashboard .dashboard-filter .filter-actions .btn { flex: 1; }
    }
    @media (prefers-reduced-motion: reduce) {
        .teacher-dashboard .dashboard-summary,
        .teacher-dashboard .trend-card { animation: none; }
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 accent-blue">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content teacher-dashboard">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <!-- small box -->
                    <div class="small-box dashboard-summary">
                        <div class="inner">
                            <h3 class="text-black"><?php echo $learners_count; ?></h3>

                            <p class="text-black">Learners in your school</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                            
                        </div>
                        <a href="dashboard.php" class="small-box-footer">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <form method="GET" action="" class="dashboard-filter mb-4">
                <div class="row align-items-end">
                    <div class="col-12 col-md-3 col-lg-2">
                        <label for="year" class="filter-label">Reporting year</label>
                        <select class="form-control" name="year" id="year">
                        <?php
                           for ($y = $current_year; $y >= 2000; $y--) {
                               $selected = ($selected_year == $y) ? 'selected' : '';
                               echo "<option value='$y' $selected>$y</option>";
                           }
                           ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 mt-3 mt-md-0 d-flex filter-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter mr-1"></i> Apply filter</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary ml-2">Reset</a>
                    </div>
                </div>
            </form>
            <?php if ($dashboardDataErrors): ?>
                <div class="alert alert-warning" role="alert"><?php echo htmlspecialchars(implode(' ', $dashboardDataErrors), ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card trend-card">
                        <div class="card-header">
                            <h2 class="card-title"><i class="fas fa-chart-line"></i>Mean Percentage Score Trends</h2>
                            <span class="term-badge">T1 – T3</span>
                        </div>
                        <div class="card-body">
                            <div class="trend-chart-wrap"><canvas id="trendChart" role="img" aria-label="Mean percentage score trends for Terms 1 through 3"></canvas></div>
                            <p class="trend-note">Subject performance across Terms 1–3 for <?php echo htmlspecialchars((string) $selected_year, ENT_QUOTES, 'UTF-8'); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                                  $sql = "
                                        SELECT 
                                            s.school_id,
                                            s.district,
                                            YEAR(l.created_at) AS year,
                                            l.grade_level,
                                            l.quarter,
                                            ROUND((SUM(l.english) / SUM(l.t_english)) * 100, 2) AS english_mps,
                                            ROUND((SUM(l.filipino) / SUM(l.t_filipino)) * 100, 2) AS filipino_mps,
                                            ROUND((SUM(l.aralpan) / SUM(l.t_aralpan)) * 100, 2) AS aralpan_mps,
                                            ROUND((SUM(l.esp) / SUM(l.t_esp)) * 100, 2) AS esp_mps,
                                            ROUND((SUM(l.math) / SUM(l.t_math)) * 100, 2) AS math_mps,
                                            ROUND((SUM(l.science) / SUM(l.t_science)) * 100, 2) AS science_mps,
                                            ROUND((SUM(l.mapeh) / SUM(l.t_mapeh)) * 100, 2) AS mapeh_mps,
                                            ROUND((SUM(l.tle) / SUM(l.t_tle)) * 100, 2) AS tle_mps
                                        FROM learners_score l
                                        JOIN schools s ON l.school_id = s.school_id
                                        WHERE l.t_english > 0 AND l.t_filipino > 0 AND l.t_aralpan > 0 
                                            AND l.t_esp > 0 AND l.t_math > 0 AND l.t_science > 0 
                                            AND l.t_mapeh > 0 AND l.t_tle > 0
                                            AND l.created_at >= '$year_start' AND l.created_at < '$next_year_start'
                                            AND l.school_id = '$school_id'
                                            AND l.quarter IN (1, 2, 3)";

                                    // Group and order by district
                                    $sql .= " GROUP BY s.district, year, grade_level, quarter 
                                              ORDER BY s.district, year DESC, grade_level, quarter";

                $query = mysqli_query($DB, $sql);
                $data = [];
                $mpsQueryError = false;

                if (!$query) {
                    error_log('Teacher dashboard MPS query failed: ' . mysqli_error($DB));
                    $mpsQueryError = true;
                } else {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $quarter = "T" . $row['quarter'];
                        $data[$quarter]['english'] = $row['english_mps'];
                        $data[$quarter]['filipino'] = $row['filipino_mps'];
                        $data[$quarter]['aralpan'] = $row['aralpan_mps'];
                        $data[$quarter]['esp'] = $row['esp_mps'];
                        $data[$quarter]['math'] = $row['math_mps'];
                        $data[$quarter]['science'] = $row['science_mps'];
                        $data[$quarter]['mapeh'] = $row['mapeh_mps'];
                        $data[$quarter]['tle'] = $row['tle_mps'];
                    }
                }

                $jsonData = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
                ?>
            <?php if ($mpsQueryError): ?>
                <div class="alert alert-warning" role="alert">Mean percentage score trends could not be loaded.</div>
            <?php endif; ?>
            <?php
                // Base SQL query
                $sql = "
                    SELECT 
                    district,
                        YEAR(created_at) AS year,
                        grade_level,
                        quarter,
                        ROUND(AVG(english), 2) AS avg_english,
                        ROUND(AVG(filipino), 2) AS avg_filipino,
                        ROUND(AVG(aralpan), 2) AS avg_aralpan,
                        ROUND(AVG(esp), 2) AS avg_esp,
                        ROUND(AVG(math), 2) AS avg_math,
                        ROUND(AVG(science), 2) AS avg_science,
                        ROUND(AVG(mapeh), 2) AS avg_mapeh,
                        ROUND(AVG(tle), 2) AS avg_tle
                    FROM learners_grade
                    WHERE 
                     created_at IS NOT NULL
                    AND created_at >= '$year_start' AND created_at < '$next_year_start'
                    AND school_id = '$school_id'
                    AND quarter IN (1, 2, 3)";
                     // Group and order results
                     $sql .= " GROUP BY district, year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     
                // Execute query
                $query = mysqli_query($DB, $sql);

                if (!$query) {
                    error_log('Teacher dashboard proficiency query failed: ' . mysqli_error($DB));
                    $chartDatag1 = [];
                    $proficiencyQueryError = true;
                } else {
                    $proficiencyQueryError = false;
                    $chartDatag1 = [];
                    while ($row = mysqli_fetch_assoc($query)) {
                        $chartDatag1[] = [
                            'quarter' => (int) $row['quarter'],
                            'avg_english' => $row['avg_english'],
                            'avg_filipino' => $row['avg_filipino'],
                            'avg_aralpan' => $row['avg_aralpan'],
                            'avg_esp' => $row['avg_esp'],
                            'avg_math' => $row['avg_math'],
                            'avg_science' => $row['avg_science'],
                            'avg_mapeh' => $row['avg_mapeh'],
                            'avg_tle' => $row['avg_tle']
                        ];
                    }
                }
                $proficiencyJson = json_encode($chartDatag1, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="card trend-card">
                        <div class="card-header">
                            <h2 class="card-title"><i class="fas fa-chart-area"></i>Level of Proficiency Trends</h2>
                            <span class="term-badge">T1 – T3</span>
                        </div>
                        <div class="card-body">
                            <?php if ($proficiencyQueryError): ?>
                                <div class="alert alert-warning" role="alert">Level of proficiency trends could not be loaded.</div>
                            <?php endif; ?>
                            <div class="trend-chart-wrap"><canvas id="quarterlyChart" role="img" aria-label="Average proficiency grades by subject for Terms 1 through 3"></canvas></div>
                            <p class="trend-note">Average subject grades across Terms 1–3 for <?php echo htmlspecialchars((string) $selected_year, ENT_QUOTES, 'UTF-8'); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var terms = ["T1", "T2", "T3"];
                        var subjects = ["english", "filipino", "aralpan", "esp", "math", "science", "mapeh", "tle"];
                        var subjectColors = [
                            "#168a83", "#315c91", "#d39b37", "#7954a1",
                            "#e16f4d", "#3f8f63", "#607d8b", "#bb6381"
                        ];
                        var mpsData = <?php echo $jsonData ?: '{}'; ?>;
                        var proficiencyRows = <?php echo $proficiencyJson ?: '[]'; ?>;
                        var proficiencyData = {};

                        subjects.forEach(function (subject) {
                            proficiencyData[subject] = [null, null, null];
                        });
                        proficiencyRows.forEach(function (row) {
                            var termIndex = Number(row.quarter) - 1;
                            if (termIndex < 0 || termIndex > 2) return;
                            subjects.forEach(function (subject) {
                                var value = row["avg_" + subject];
                                proficiencyData[subject][termIndex] = value === null ? null : Number(value);
                            });
                        });

                        function buildDatasets(source) {
                            return subjects.map(function (subject, index) {
                                return {
                                    label: subject.charAt(0).toUpperCase() + subject.slice(1),
                                    data: terms.map(function (term) {
                                        var value = source[term] && source[term][subject];
                                        return value === null || value === undefined ? null : Number(value);
                                    }),
                                    borderColor: subjectColors[index],
                                    backgroundColor: subjectColors[index],
                                    fill: false,
                                    lineTension: 0.35,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    spanGaps: false
                                };
                            });
                        }

                        function renderTrendChart(canvasId, source, yAxisLabel) {
                            var canvas = document.getElementById(canvasId);
                            if (!canvas || typeof Chart === "undefined") return;

                            new Chart(canvas.getContext("2d"), {
                                type: "line",
                                data: { labels: terms, datasets: buildDatasets(source) },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    legend: {
                                        position: "bottom",
                                        labels: { usePointStyle: true, padding: 16 }
                                    },
                                    tooltips: {
                                        mode: "index",
                                        intersect: false,
                                        callbacks: {
                                            label: function (tooltipItem, chartData) {
                                                var label = chartData.datasets[tooltipItem.datasetIndex].label || "";
                                                return label + ": " + tooltipItem.yLabel + "%";
                                            }
                                        }
                                    },
                                    hover: { mode: "nearest", intersect: true },
                                    scales: {
                                        xAxes: [{
                                            scaleLabel: { display: true, labelString: "Term" },
                                            gridLines: { display: false }
                                        }],
                                        yAxes: [{
                                            ticks: { beginAtZero: true, min: 0, max: 100 },
                                            scaleLabel: { display: true, labelString: yAxisLabel },
                                            gridLines: { color: "rgba(23, 43, 77, .08)" }
                                        }]
                                    }
                                }
                            });
                        }

                        var proficiencyByTerm = {};
                        proficiencyRows.forEach(function (row) {
                            proficiencyByTerm["T" + row.quarter] = row;
                        });
                        var proficiencyForChart = {};
                        terms.forEach(function (term, index) {
                            if (!proficiencyByTerm[term]) return;
                            proficiencyForChart[term] = {};
                            subjects.forEach(function (subject) {
                                proficiencyForChart[term][subject] = proficiencyData[subject][index];
                            });
                        });

                        renderTrendChart("trendChart", mpsData, "Mean percentage score (%)");
                        renderTrendChart("quarterlyChart", proficiencyForChart, "Average grade (%)");
                    });
                </script>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
</div>
    <script type="text/javascript">
        // Reload the page when user attempts to navigate back
        window.onbeforeunload = function () {
            location.reload(true);
        };
    </script>
<?php
include('includes/footer.php');
?>