<?php
$uri = parse_url($_SERVER['REQUEST_URI']);
$query = $uri['query'];
parse_str($query, $parr);
$testId = $parr['resultId'];
$fh = fopen("/tmp/".$testId, 'r');
$score = 0;
if ($fh) {
    while(!feof($fh)) {
	$line = fgets($fh);
	parse_str($line, $parr);
	$score += $parr['score'];
    }
}
$score = round($score);
$agent = $_SERVER['HTTP_USER_AGENT'];
$browser     = '';
$browser_ver = '';
if (preg_match('/SamsungBrowser\/([^\s]+)/i', $agent, $regs))
{
    $browser = 'SamsungBrowser';
    $browser_ver = $regs[1];
}
elseif (preg_match('/Chrome\/([^\s]+)/i', $agent, $regs))
{
    $browser = 'Chrome';
    $browser_ver = $regs[1];
}
elseif (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
{
    $browser     = 'Internet Explorer';
    $browser_ver = $regs[1];
}
elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
{                            
    $browser     = 'FireFox';
    $browser_ver = $regs[1];
}
elseif (preg_match('/Maxthon/i', $agent, $regs))
{
    $browser     = '(Internet Explorer ' .$browser_ver. ') Maxthon';
    $browser_ver = '';
}
elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
{
    $browser     = 'Opera';
    $browser_ver = $regs[1];
}
elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
{
    $browser     = 'OmniWeb';
    $browser_ver = $regs[2];
}
elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
{
    $browser     = 'Netscape';
    $browser_ver = $regs[2];
}
elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
{
    $browser     = 'Safari';
    $browser_ver = $regs[1];
}
elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
{
    $browser     = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
    $browser_ver = $regs[1];
}
elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
{
    $browser     = 'Lynx';
    $browser_ver = $regs[1];
}
?>

<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/Product">
<head>
  <meta charset="utf-8">
  <title>Peacekeeper - free universal browser test for HTML5 from Futuremark</title>
  <meta name="description" content="See which HTML5 browser is the fastest browser with this free browser speed test. Test your PC, smartphone or tablet. Works with any browser on any device.">
  <meta name="author" content="Futuremark">
  <meta name="viewport" content="width=1000">
	
  <link rel="stylesheet" href="css/application-style2.css">
  <link rel="stylesheet" href="css/jquery-ui-smoothness/jquery-ui-1.8.13.custom.css">
	<script src="js/libs/jquery-1.6.4.min.js"></script>
	<script src="js/libs/jquery-ui-1.8.13.custom.min.js"></script>
	<script src="js/peacekeeper.js"></script>
  <meta itemprop="name" content="Peacekeeper">
  <meta itemprop="description" content="Which is the fastest browser? Find out with Peacekeeper">
  <meta property="og:title" content="Peacekeeper - free universal browser test for HTML5 from Futuremark"/>
  <meta property="og:type" content="browser test"/>
  <meta property="og:url" content="http://peacekeeper.futuremark.com/"/>
  <meta property="og:image" content="http://peacekeeper.futuremark.com/images/v2/facebook-helmet.jpg"/>
  <meta property="og:site_name" content="Peacekeeper"/>
  <meta property="og:description" content="See which HTML5 browser is the fastest browser with this free browser speed test. Test your PC, smartphone or tablet. Works with any browser on any device."/>
  
		<style>
		body {
			background: url(images/v2/hill-result.jpg) no-repeat center top;
    }
    </style>
  
</head>
<body>

  <div id="wrapper">
    <div id="header">
      <div id="cloud-left"><p>Works with all browsers on Windows, Mac, Linux, Android, iOS and more</p></div>
      <div id="logo-area">
        <h1>
          <!--<div id="logo-beta-anchor"><img id="logo-beta" src="images/v2/beta.png" /></div>-->
          <a href="/"><img src="images/v2/pk-logo.png" /></a>
          <div class="tagline">The Universal Browser Test</div>
        </h1>
		  <div class="no-longer-supported">
			  <h2>Peacekeeper is no longer supported.</h2>
			  <p>We recommend <a href="http://www.futuremark.com/benchmarks/pcmark8">PCMark 8</a> for benchmarking Windows PCs. For Android smartphones and tablets, we recommend <a href="http://www.futuremark.com/benchmarks/pcmark-android">PCMark for Android.</a></p>
		  </div>
      </div>
      <div id="header-right">

        <div id="facebook-login-button">
          <fb:login-button onlogin="facbookLoginComplete()">Login with Facebook</fb:login-button>
        </div>
        <div id="facebook-login-status">
          Hi <span class="facebook-username"></span>! <a href="javascript:peacekeeper.openMyResults()">View your results</a>.
        </div>
        <div id="cloud-right">
          <p>Works with PCs, notebooks, netbooks, tablets, smartphones and other HTML5 compatible devices.</p>
        </div>
  
      </div>
    </div>

  	

  <script>
    var facebookAppId = '250615361649960';
  </script>

	

	<!-- Dialogs -->
	<div id="result-dialog" title="Result details"></div>
	<div id="save-dialog" title="Save your result">
	  <p>Save this result by using <a href="javascript:facebookLogin()">Facebook</a></p>
	</div>
	<div id="run-dialog" class="clearfix" title="Use this address to test other browsers">
    <!--
  	<a class="run-dialog-button-area" href="run.action.php" class="">
  	  <img src="images/v2/button-go.png" />
  	</a>
  	<div class="run-dialog-login-button-area">
      <p>This result is owned by <span class="facebook-username">anonymous</span>. If this is you, please login before running benchmark.</p>
      <fb:login-button onlogin="facbookLoginComplete()">Login with Facebook</fb:login-button>
  	</div>
  	-->
  	<div class="run-dialog-copyurl-area">
      <input type="text" onclick="select()" value="http://peacekeeper.futuremark.com/" />
  	</div>
	</div>
	<div id="setcomment-dialog" title="Name result">
	  <p>Give a name for this result</p>
	  <input type="text" name="comment" value="New result" style="width: 100%;" />
	  <input type="hidden" name="key" value="CZRP" />
	</div>
	
	
  
  	<img class="your-score-title" src="images/v2/your-result-title.png" />
  	<div class="your-score"><?php echo $score ?></div>
    <div class="facebook-box">
      <div id="user-facebook-info"><br /></div>
      <div id="user-comment"></div>
    </div>
  	<div id="save-result">Log in to save this result!</div>
    <div class="result-useragent">Detailed version information: <?php echo $_SERVER['HTTP_USER_AGENT'] ?></div>
  
  
  
  
  
  
  
	<div class="results">

    

      

      
        <div class="resultBarContainer clearfix " resultid="<?php echo $testId ?>">
          <div class="resultBarBrowser">
            <p>
              <em><?php echo date('Y-m-d') ?></em>
              
                <?php echo $browser ?>
		<?php echo $browser_ver ?>
              
            </p>
          </div>
          <div class="resultBarAnchor">
            <div class="resultBarBackground"></div>
            <div class="resultBar" style="width: -2%"></div>
            <div class="resultDetailsLabel">Click for details</div>
          </div>
          <div class="resultBarScore"><p><? echo $score ?></p></div>
          <div class="resultBarComment"><p></p></div>
        </div>
      
      
    

    <div class="resultBarContainer resultBarContainerEmpty clearfix">
      <div class="resultBarBrowser"><p>Test another browser</p></div>
      <a class="resultBarAnchor" onclick="runBenchmark()"></a>
      <div class="resultBarScore">
        <a href="javascript:runBenchmark()"><img src="images/v2/result-go.png" /></a>
      </div>
    </div>

    <h3 id="social-title">Share this result on:</h3>
    <ul id="social">
      <li id="social-fb">
        <a class="facebook-share-link" href="javascript:shareOnFacebook()">Like</a>
      </li>
      <li id="social-twitter">
        
        
          <a href="http://twitter.com/share?text=I'm%20comparing%20browsers%20with%20Peacekeeper.&url=http%3A%2F%2Fpeacekeeper.futuremark.com%2Fresults%3Fkey%3DCZRP" class="twitter-share-button" data-count="none" data-via="FM_Peacekeeper">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        
      </li>
      <li id="social-plus">
        <g:plusone size="small" annotation="none"></g:plusone>
        <script type="text/javascript">
          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
        </script>
      </li>
      <li id="social-forums"><a href="http://www.yougamers.com/forum/forumdisplay.php?f=95&styleid=10" target="_blank" onclick="recordOutboundLink(this, 'Outbound Links', 'yougamers.com');return false;"><img src="images/v2/results-forums.png" /></a></li>
      <li id="social-support"><a href="faq.action"><img src="images/v2/results-support.png" /></a></li>
    </ul>

    <div class="copyurl-area">
      <input type="text" onclick="select()" value="http://peacekeeper.futuremark.com/" />
    </div>

    
	</div>
	
  
  
  
	<div class="result-columns">
  	<div class="hline"></div>
    
      
      
      
    
    
      
      
      
      
      
    
  </div>	
  
  <div id="fb-root"></div>
  <script src="//connect.facebook.net/en_US/all.js"></script>
  <script>
  
    var userFbUid = 0;
    var comment = '';
    var browserName = "Chrome";
    var score = "0";
    var key = "CZRP";
    var isOwner = "false";
    
    function checkLoginStatus_resultPage()
    {

      // Try to load result owners information.
      if (userFbUid != 0)
      {

        // Display rename dialog.
        if (userFbUid == currentFbUid && comment == "")
        {
          openSetCommentDialog();
        }

        FB.api('/' + userFbUid, function(userResponse) {
          
          // Display owner information.
          if (currentFbUid == userResponse.id)
          {
            $("#user-facebook-info").text("This result is locked to you.");
          } else {
            $("#user-facebook-info").text("This result is locked.");
          }
          
        });
      } else {

        // Result is unassigned but user is logged in.
        if (currentFbUid != 0)
        {

          // Assign result to user.          
          $.ajax({
            url: 'assignUser.action?key=CZRP',
            success: function(data)
            {
              userFbUid = currentFbUid;
              checkLoginStatus_resultPage();
            }
          });
          
        } else {
          $("#user-facebook-info").text("This result is unlocked. Log in to lock this result!");
        }
        

      }

    }

    function openSaveDialog()
    {
      $("#save-dialog").dialog({
        resizable: false,
        width: 600,
        modal: true
      });
    }

    function shareOnFacebook()
    {
    
      var message = "";
      if (browserName != "" && score != "")
      {
        message = "I'm comparing browsers with Peacekeeper.  Chrome scored 0.";
      } else {
        message = "I'm comparing browsers with Peacekeeper.";
      }
    
      FB.ui({ 
        method: "feed", 
        message: "Check out my Peacekeeper result!",
        link: "http://peacekeeper.futuremark.com/results?key=CZRP",
        picture: "http://peacekeeper.futuremark.com/images/v2/pk-logo-facebook.png",
        name: "Peacekeeper Universal Browser test",
        caption: message,
        description: "Which browser is fastest? Find out with Peacekeeper.",
        actions: [
          { name: "Which browser is fastest? Find out with Peacekeeper.", 
	    link: "http://peacekeeper.futuremark.com/" }
        ]
      });
    }
    
    function runBenchmark()
    {
      
      // User is logged in to facebook => hide login button
      if (currentFbUid != 0)
      {
        $("#run-dialog").addClass("no-facebook");
      } else {
        $("#run-dialog").removeClass("no-facebook");
      }
      
      $("#run-dialog").dialog({
        resizable: false,
        width: 700,
        modal: true,
        open: function() {
          $(".run-dialog-copyurl-area input")[0].select();
        }
      });
      
    }
    
    function openSetCommentDialog()
    {
      $("#setcomment-dialog").dialog({
        resizable: false,
        width: 400,
        modal: true,
        buttons: 
        { 
          "Ok": function() 
          { 
            
            // Save result.
            $.ajax({
              url: 'saveComment.action',
              data: {
                key: 'CZRP',
                comment: $("#setcomment-dialog input[name=comment]").val()
              }
            });

            $(this).dialog("close"); 
          } 
        }
      }).prev('.ui-dialog-titlebar').find('a').hide();   
    }
    
  </script>  



    <div id="footer">
      <ul>
        <li><a href="http://www.futuremark.com/companyinfo/aboutus/" onclick="recordOutboundLink(this, 'Outbound Links', 'futuremark.com/aboutus');return false;">Company</a></li>
        <li><a href="http://www.futuremark.com/contactinfo/contactus/" onclick="recordOutboundLink(this, 'Outbound Links', 'futuremark.com/contactus');return false;">Contact</a></li>
        <li><a href="http://www.futuremark.com/companyinfo/legal/privacystatement/" onclick="recordOutboundLink(this, 'Outbound Links', 'futuremark.com/legal/privacystatement');return false;">Privacy</a></li>
        <li><a href="http://www.futuremark.com/companyinfo/advertising/" onclick="recordOutboundLink(this, 'Outbound Links', 'futuremark.com/advertising');return false;">Advertise</a></li> 
        <li class="fm-logo"><a href="http://www.futuremark.com/" onclick="recordOutboundLink(this, 'Outbound Links', 'futuremark.com');return false;"><img src="images/v2/fm-logo.png" /></a></li>
      </ul>
    </div>
  </div>

  <div id="my-results-dialog" title="My results"></div>
  
  <div id="fb-root"></div>
  <script src="//connect.facebook.net/en_US/all.js"></script>
  <script>
  
    if (typeof facebookAppId == "undefined")
    {
      var facebookAppId = 0;
    }
  
    FB.init({
      appId  : facebookAppId,
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true, // parse XFBML
      oauth :  false // enables OAuth 2.0
    });


    var currentFbUid = 0;
    
    /**
     * Login complete after button click.
     */
    function facbookLoginComplete()
    {

      // On result page, reload page after login.
      if (window.location.toString().indexOf("results.action.php") != -1)
      {
        window.location.reload();
      } 
      // On other pages just check login status.
      else {
        checkLoginStatus();      
      }
      
    }
    
    /**
     * Check login status.
     */
    function checkLoginStatus()
    {
    
      console.log("Checking login status...");
  
      $("#facebook-login-button").hide();
      $("#facebook-login-status").hide();
      $("#facebook-login-loading").show();

      FB.getLoginStatus(function(response) {

        if (response.status == "connected") {
        
          console.log("Logged in as " + response.authResponse.userID);
          currentFbUid = response.authResponse.userID;

          FB.api('/me', function(user) {
           if(user != null) 
           {
              $("#facebook-login-button").hide();
              $("#facebook-login-status").show();
              $("#facebook-login-loading").hide();
              $(".facebook-username").text(user.name);
           } else {
              $("#facebook-login-button").show();
              $("#facebook-login-status").hide();
              $("#facebook-login-loading").hide();
           }
          });

        } else {
          console.log("Not logged in...");
          $("#facebook-login-button").show();
          $("#facebook-login-status").hide();
          $("#facebook-login-loading").hide();
        }

        if (typeof(checkLoginStatus_resultPage) != "undefined")
        {
          checkLoginStatus_resultPage();
        }
  
      });
    }
    
    checkLoginStatus();
  </script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-1629879-17', 'auto', {'allowLinker': true});
        ga('require', 'linker');
        ga('linker:autoLink', ['futuremark.com', '3dmark.com']);      // Domains that are linked from this page.
        ga('send', 'pageview');
    </script>

  <script type="text/javascript">
//    var orbTracker = _gat._getTracker("UA-1629879-4");
//    orbTracker._trackPageview();

    var fmNetworkTracker = _gat._getTracker("UA-1629879-7");
    fmNetworkTracker._setDomainName("none");
    fmNetworkTracker._setAllowLinker(true);
    fmNetworkTracker._trackPageview();
  </script>

  <script type="text/javascript">
    function recordOutboundLink(link, category, action) 
    {
      orbTracker._trackEvent(category, action);
      $.ajax({
        url: "/?action=" + action,
        error: function()
        {
          setTimeout('document.location = "' + link.href + '"', 100);
        },
        success: function()
        {
          setTimeout('document.location = "' + link.href + '"', 100);
        }
      });
    }
  </script>

  <script src="http://clients.futuremark.com/dibbs/navigationRibbon/navigationRibbonJs"></script>

  <!-- GetSatisfaction widget -->		
  <script type="text/javascript" charset="utf-8">
    var is_ssl = ("https:" == document.location.protocol);
    var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
    document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript" charset="utf-8">
    var feedback_widget_options = {};
    feedback_widget_options.display = "overlay";  
    feedback_widget_options.company = "futuremark";
    feedback_widget_options.placement = "left";
    feedback_widget_options.color = "#222";
    feedback_widget_options.style = "idea";
    feedback_widget_options.product = "futuremark_peacekeeper";
    feedback_widget_options.limit = "3";
    var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
  </script>

</body>
</html>
