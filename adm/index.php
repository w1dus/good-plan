<?php
  $sub_menu = '100000';
  require_once './_common.php';

  @require_once './safe_check.php';
  if (function_exists('social_log_file_delete')) {
      social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
  }

  $g5['title'] = '관리자메인';
  require_once './admin.head.php';

  
?>





<div class="box">
  <h1>대시보드</h1>
  <div class="margin-div"></div>
  <h2> 방문자 접속통계</h2>

  <div class="total-hit-count-div">
    <div class="item">
      <div class="label">오늘 방문자 수</div>
      <div class="count">
        <?php 
          $sql_today = "SELECT COUNT(*) as cnt FROM g5_visit WHERE vi_date = CURDATE()";
          $result_today = sql_query($sql_today);
          $row_today = sql_fetch_array($result_today);
          $today_count = number_format($row_today['cnt']);

          echo $today_count; 
        ?>
      </div>
    </div>
    <div class="item">
      <div class="label">총 방문자 수</div>
      <div class="count">
        <?php 
          $sql_total = "SELECT COUNT(*) as cnt FROM g5_visit";
          $row_total = sql_fetch_array(sql_query($sql_total));
          $total_count = number_format($row_total['cnt']);
          echo $total_count; 
        ?>
      </div>
    </div>
    <div class="item">
      <div class="label">어제 방문자 수</div>
      <div class="count">
        <?php 
          $sql_yesterday = "SELECT COUNT(*) as cnt FROM g5_visit WHERE vi_date = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
          $row_yesterday = sql_fetch_array(sql_query($sql_yesterday));
          $yesterday_count = number_format($row_yesterday['cnt']);

          echo $yesterday_count;
        ?>
      </div>
    </div>
    <div class="item">
      <div class="label">금주 방문자 수</div>
      <div class="count">
        <?php 
          //이번 주 방문자 수 (월요일 ~ 오늘)
          $sql_week = "SELECT COUNT(*) as cnt FROM g5_visit WHERE YEARWEEK(vi_date, 1) = YEARWEEK(CURDATE(), 1)";
          $row_week = sql_fetch_array(sql_query($sql_week));
          $week_count = number_format($row_week['cnt']);
          echo $week_count;
        ?>
      </div>
    </div>
  </div>
</div>






<div class="margin-div"></div>


<div class="dashboard-half">
  <div class="box-wrap">
    <?php
      $start = date('Y-m-d', strtotime('-6 days')); // 6일 전
      $end   = date('Y-m-d');                       // 오늘

      // 하루 단위 방문 기록 전체 가져오는 함수 (DATETIME 범위)
      function getDailyVisits($date) {
          global $g5;
          $visit_table = $g5['visit_table'];

          $day_start = $date . " 00:00:00";
          $day_end   = $date . " 23:59:59";

          $sql = "
            SELECT *
            FROM {$visit_table}
            WHERE vi_date BETWEEN '{$day_start}' AND '{$day_end}'
            ORDER BY vi_id DESC
          ";
          $result = sql_query($sql);

          $visits = [];
          while ($row = sql_fetch_array($result)) {
              $visits[] = $row;
          }

          return $visits;
      }

      // 일주일치 배열 생성 및 방문자 수 집계
      $weekly_visits = [];
      $labels = [];
      $data = [];
      for ($i = 0; $i < 7; $i++) {
          $date = date('Y-m-d', strtotime("$start +$i day"));
          $daily_visits = getDailyVisits($date);
          $weekly_visits[$date] = $daily_visits;

          // 그래프용 데이터: 조회수 기준
          $labels[] = $date;
          $data[] = count($daily_visits);
      }
    ?>
    <div class="title-space-box">
      <h2> 방문자 집계 그래프 (<?php echo $start." ~ ".$end; ?>)</h2>
      <a href="<?=G5_ADMIN_URL;?>/visit_list.php?token=86df70e3c47f36124da16438944c4972&fr_date=<?=$start?>&to_date=<?=$end?>" class="btn_admin">바로가기</a>
    </div>
    <div class="visit-chart">
      <canvas id="visit-chart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const labels = <?php echo json_encode($labels, JSON_UNESCAPED_UNICODE); ?>;
      const dataValues = <?php echo json_encode($data); ?>;

      const data = {
        labels: labels,
        datasets: [{
          label: '일별 방문자 수',
          backgroundColor: 'rgb(93,91,208)',
          borderColor: 'rgb(93,91,208)',
          data: dataValues,
        }]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: { 
              min: 0,            // y축 최소값 0
              beginAtZero: true, // 0부터 시작
              ticks: { stepSize: 1 }
            }
          }
        }
      };

      const ctx = document.getElementById('visit-chart').getContext('2d');
      const chart = new Chart(ctx, config);
    </script>
  </div>
  <div class="box-wrap">
  
    <?php 
      //게시판 id를 입력해주세요.
      $board = "apply";
    ?>

      <div class="title-space-box">
        <h2> 최근 문의 목록</h2>
        <a href="<?=G5_BBS_URL;?>/board.php?bo_table=<?=$board;?>" target="_blank" class="btn_admin">바로가기</a>
      </div>
      <article class="boardArti basicBoardArti">
        <ul class="basicList">
            <li class="boardTitle">
                <div class="item">
                    <div class="title center">제목</div>
                    <div class="writer center">글쓴이</div>
                    <div class="date center">등록일</div>
                </div>
            </li>
            <?php 
              $sql = "SELECT * FROM `g5_write_".$board."` WHERE `wr_id` ORDER BY `wr_datetime` DESC LIMIT 0,5";
              $result = sql_query($sql);

              for($i=0; $row=sql_fetch_array($result); $i++) {
            ?>
            <li>
                <div class="item">
                    <div class="title"><a href="<?=G5_BBS_URL;?>/board.php?bo_table=<?=$board;?>&wr_id=<?=$row['wr_id']; ?>" target="_blank"><?=$row['wr_subject']; ?></a></div>
                    <div class="writer center"><?=$row['wr_name']; ?></div>
                    <div class="date center"><?=date('Y-m-d', strtotime($row['wr_datetime'])); ?></div>
                </div>
            </li>
            <?php } ?>
            <?php 
              if ($i == 0) {
                  echo '<li class="empty_table">등록된 자료가 없습니다.</li>';
              }
            ?>
        </ul>
      </article>
  </div>
</div>


<?php
  require_once './admin.tail.php';
  ?>
