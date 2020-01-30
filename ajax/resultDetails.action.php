<?php
$uri = parse_url($_SERVER['REQUEST_URI']);
$query = $uri['query'];
parse_str($query, $parr);
$testId = $parr['id'];

$fh = fopen("/tmp/".$testId, 'r');
$testsuites = array();
$tscore = 0;
if ($fh) {
    while(!feof($fh)) {
	$line = fgets($fh);
	if (empty($line))
		continue;
	parse_str($line, $parr);
	$suite = $parr['suite'];
        $tscore += $parr['score'];
	if (array_key_exists($suite, $testsuites)) {
	    $as = &$testsuites[$suite];
            array_push($as, $parr);
	} else {
            $tests = array();
            $tests[0] = $parr;
	    $testsuites[$suite] = $tests;
	}
    }
}
$tscore = round($tscore);
print <<<EOT
<script>
  var RESULT_ID = "{$testId}";
  $(document).ready(function()
  {

    $("#resultComment, #editComment").click(function()
    {
      $("#resultComment").hide();
      $("#resultCommentForm").show();
    });

    $("#resultCommentSave").click(function()
    {
      var comment = $("#resultCommentInput").val();
      $("#resultComment p").html(comment);
      $("#resultComment").show();
      $("#resultCommentForm").hide();
      $.ajax({
        url: "saveResultComment.action",
        data: {
          resultId: RESULT_ID,
          comment: comment
        }
      });
    });

    $("#deleteResult").click(function()
    {
      if (confirm("Are you sure you want to delete this result?"))
      {
        window.location = "deleteResult.action?key=" + key + "&resultId=" + RESULT_ID;
      }
    });

  });
</script>
<div id="browserInfo" class="clearfix">
	<h2>Chrome</h2>
	<h1>{$tscore} Points</h1>
	<dl class="clearfix">
	  <dd>Version info</dd>
	  <dt>{$_SERVER['HTTP_USER_AGENT']}</dt>
	  <dd>Comment</dd>
	  <dt>
	    
	    
        <p>
          
          
            
          
        </p>
	    
	  </dt>
	</dl>
  
</div>
<div class="barContainerDetailsPadding">
	<div id="browserTitleKey"><span>Suite</span></div>
	<div id="browserTitleValue">Result</div>
	
		<div class="barContainerDetails">
EOT;

$suiteTitle = array();
$suiteTitle['experimental'] = 'HTML5 Canvas';
$suiteTitle['html5'] = 'HTML5 Capabilities';

foreach ($testsuites as $key=>&$test) {
	$tscore = 0;
	$sz = count($test);
	foreach ($test as &$tt) {
		$tscore += $tt['score'];
	}
	$tscore = round($tscore/$sz, 2);
	if ($key == 'html5')
		$tscore = '1/7';
	print <<<EOT
          <div class="label suite"><span>{$suiteTitle[$key]}</span></div>
          <div class="score suite">{$tscore}</div>
          <div style="clear: both;"></div>
EOT;
	foreach ($test as &$tt) {
		$name = $tt['name'];
		$score = round($tt['score'], 2);
		$unit = $tt['unit'];
		$yes = '';
		$yese = '';
		if ($tt['suite'] == 'html5' &&  $score > 0) {
		    $yes = 'Yes (';
		    $yese = ')';
		}
		print <<<EOT
	        <div class="label"><span>{$name}</span></div>
	         <div class="score">
        	      {$yes}{$score} {$unit}{$yese}
            	 </div>
EOT;

	}
	print <<<EOT
	<div style="clear: both;"></div>
EOT;
}
print <<<EOT
</div>
</div>
EOT;
?>
