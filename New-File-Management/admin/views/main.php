<style>
    canvas {
            max-width: 100%;
            height: auto;
            margin: auto;
            display: block;
        }
</style>
<main>
    <div class="header">
        <div class="left">
            <h1>Dashboard</h1>
        </div>
    </div>

    <!-- Insights -->
    <ul class="insights">
        <li onclick="window.location.href='user.php'">
            <i class='bx bx-user'></i>
            <span class="info">
                <h3 id="load_user">
                <?= $countUser ?>
                </h3>
                <p>Users</p>
            </span>
        </li>
        <li onclick="window.location.href='repository.php'"><i class='bx bx-file-blank'></i>
            <span class="info">
                <h3 id="load_file">
                <?= $countFile ?>
                </h3>
                <p>Files</p>
            </span>
        </li>
        <li onclick="window.location.href='repository.php'"><i class='bx bx-download'></i>
            <span class="info">
                <h3 id="load_download">
                <?= $countDownload ?>
                </h3>
                <p>Downloads</p>
            </span>
        </li>
        <li onclick="window.location.href='repository.php'"><i class='bx bxs-like'></i>
            <span class="info">
                <h3 id="load_like">
                <?= $countLike ?>
                </h3>
                <p>Likes</p>
            </span>
        </li>
    </ul>

    <div class="bottom-data">
        <div class="orders">
            <div class="header">
                <i class='bx bx-bar-chart-alt-2'></i>
                <h3>Download Graph</h3>
            </div>
            <div class="chart">
                <canvas id="downloadsChart"></canvas>  
            </div>
        </div>

        <div class="reminders">
            <div class="header">
                <i class='bx bx-note'></i>
                <h3>Recent Upload</h3>
            </div>
            <ul class="task-list">
            </ul>
        </div>

        <!-- End of Reminders-->

    </div>
</main>

<script>
    $(document).ready(function(){
        function loadGraph(){
            $.ajax({
                url: 'admin_ajax.php',
                method: 'GET',
                dataType: 'json',
                data: {loadGraph: 'loadGraph'},
                success: function(response) {
                    const labels = response.map(entry => entry.download_date);
                    const dataValues = response.map(entry => entry.total_downloads);

                    // Create chart data
                    const data = {
                        labels: labels,
                        datasets: [{
                            label: 'Downloads',
                            backgroundColor: 'rgba(52, 152, 219, 0.5)',
                            borderColor: 'rgba(52, 152, 219, 1)',
                            borderWidth: 1,
                            data: dataValues,
                        }]
                    };

                    // Get canvas element and initialize chart
                    const ctx = document.getElementById('downloadsChart').getContext('2d');
                    const downloadsChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0,
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
        function recentUpload(){
            $.ajax({
                type: 'GET',
                url: 'admin_ajax.php',
                dataType: 'json',
                data: {contentFile : 'contentFile'},
                success: function(response){
                    var loadFile = '';

                    response.forEach(function(item){
                        loadFile += '<li>';
                        loadFile += '<div class="task-title">';
                        loadFile += '<p>'+item.file_name+'</p>';
                        loadFile += '</div>';
                        loadFile += '</li>';
                    });
                    $('.task-list').html(loadFile);
                }
            });
        }
        recentUpload();
        function loadUser(){
            $.ajax({
                type: 'GET',
                url: 'admin_ajax.php',
                dataType: 'json',
                data: {loadUser : 'loadUser'},
                success: function(response){
                    var res = JSON.parse(response);
                    $('#load_user').html(res);
                }
            });
        }
        function loadFile(){
            $.ajax({
                type: 'GET',
                url: 'admin_ajax.php',
                dataType: 'json',
                data: {loadFile : 'loadFile'},
                success: function(response){
                    var res = JSON.parse(response);
                    $('#load_file').html(res);
                }
            });
        }
        function loadDownload(){
            $.ajax({
                type: 'GET',
                url: 'admin_ajax.php',
                dataType: 'json',
                data: {loadDownload : 'loadDownload'},
                success: function(response){
                    var res = JSON.parse(response);
                    $('#load_download').html(res);
                }
            });
        }
        function loadLike(){
            $.ajax({
                type: 'GET',
                url: 'admin_ajax.php',
                dataType: 'json',
                data: {loadLike : 'loadLike'},
                success: function(response){
                    var res = JSON.parse(response);
                    $('#load_like').html(res);
                }
            });
        }
        //Call all the function
        loadUser();
        loadFile();
        loadDownload();
        loadLike();
        loadGraph();
    });
        function adjustChartSize() {
            const canvas = document.getElementById('downloadsChart');
            const parentWidth = canvas.parentElement.clientWidth;

            canvas.style.height = '200px';
            canvas.style.width = parentWidth + 'px';
        }

        document.addEventListener('DOMContentLoaded', function() {
            adjustChartSize();
        });

        window.addEventListener('resize', adjustChartSize);
</script>