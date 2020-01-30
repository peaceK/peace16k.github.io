<?php
class TestSuite {
	public $suiteProgress;
	public $suiteName;
	public $suiteTitle;
	public $suiteDescription;
	public $testObjectName;
	public $testDescription;
	public $remainingTime;
}

$experimentalRipple01 = new TestSuite;
$experimentalRipple01->suiteProgress = 0;
$experimentalRipple01->suiteName = "experimental";
$experimentalRipple01->suiteTitle = "HTML5 Canvas";
$experimentalRipple01->suiteDescription = "The canvas test evaluates your browsers element is ability to create dynamic, scriptable rendering of 2D shapes and bitmap images.";
$experimentalRipple01->testObjectName = "experimentalRipple01";
$experimentalRipple01->testDescription = "The canvas test evaluates your browsers ability to create dynamic, scriptable rendering of 2D shapes and bitmap images. First test has a fairly small area inside which we simulate a water ripple effect.";
$experimentalRipple01->remainingTime = "3 minutes left";

$experimentalRipple02 = new TestSuite;
$experimentalRipple02->suiteProgress = 1;
$experimentalRipple02->suiteName = "experimental";
$experimentalRipple02->suiteTitle = "HTML5 Canvas";
$experimentalRipple02->suiteDescription = "The canvas test evaluates your browsers element is ability to create dynamic, scriptable rendering of 2D shapes and bitmap images.";
$experimentalRipple02->testObjectName = "experimentalRipple02";
$experimentalRipple02->testDescription = "Here we have the same ripple effect, but with a much larger area. ";
$experimentalRipple02->remainingTime = "2 minutes left";

$webglSphere  = new TestSuite;
$webglSphere->suiteProgress = 2;
$webglSphere->suiteName = "html5";
$webglSphere->suiteTitle = "HTML5 Capabilities";
$webglSphere->suiteDescription = "Now testing your browsers HTML5 features: HTML5 video, WebGL 3D graphics and multithreaded Web Workers. These tests do not count toward the overall performance score.";
$webglSphere->testObjectName = "webglSphere";
$webglSphere->testDescription = "The WebGL in HTML5 allows fullblown 3D graphics within the browser without any addons. The test renders a simple transparent 3D sphere, inside which are six bumbmapped spheres. The balls bounce within the cube with real simplified physics. ";
$webglSphere->remainingTime = "1 minutes left";

$testSuites = array(
	"1" => $experimentalRipple01,
	"2" => $experimentalRipple02,
	"3" => $webglSphere,
);

$uri = parse_url($_SERVER['REQUEST_URI']);
$sn = preg_replace('/=/', '', $uri[query]);
$testId = substr($sn, 6);
session_name($sn);
session_start();
$_SESSION['gindex']++;
$index = $_SESSION['gindex'];
if ($_SESSION['gindex'] >= 4) {
    $_SESSION['gindex'] = 0;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<!-- Futuremark Peacekeeper -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Peacekeeper</title>

<?php
if ($index < 4) {
print <<<EOT
<!-- Fallback refresh after 120 seconds. -->
<meta http-equiv="refresh" content="120; url=runtimeout.action@testName=renderGrid01">

<link rel="stylesheet" href="css/test-style.css" type="text/css" media="screen" />

<script src="js/libs/jquery-1.6.4.min.js"></script>
<script src="js/benchmark.js"></script>
<script src="js/assetmanager.js"></script>
EOT;
} else {
print <<<EOT
	<script type="text/javascript">
	parent.ui.showResult("CZRP", "{$testId}");
	</script>

	</head>
	<body>

	<div style="color: #808080; font-family: tahoma; font-size: 12px; line-height: 558px; text-align: center;">All tests done, now loading your result...</div>

	</body>
	</html>
EOT;
}
?>

<?php
  if ($index == 3) { # for webglSphere 
print <<<EOT
	<script type="text/javascript" src="js/Collisions.js"></script>
	<script type="text/javascript" src="js/mjs.js"></script>
EOT;
  }	
?>

<?php
if ($index < 4) {
print <<<EOT
<script type="text/javascript">
benchmark.suiteProgress = "{$testSuites[$index]->suiteProgress}";
benchmark.suiteCount = 3;
benchmark.suiteName = "{$testSuites[$index]->suiteName}";
benchmark.suiteTitle = "{$testSuites[$index]->suiteTitle}";
benchmark.suiteBackground = "";
benchmark.suiteDescription = "{$testSuites[$index]->suiteDescription}";
benchmark.remainingTime = "{$testSuites[$index]->remainingTime}";
benchmark.testObjectName = "{$testSuites[$index]->testObjectName}";
benchmark.testDescription = "{$testSuites[$index]->testDescription}";
</script>
EOT;
}
?>

<?php
  if ($index == 3) { # for webglSphere 
print <<<EOT
<script id="vsh_sphere" type="x-shader/x-vertex">
uniform mat4 uProjMatrix;
uniform mat4 uModelMatrix;
uniform mat4 uViewMatrix;
uniform mat4 uNormalMatrix;

attribute vec4 aPosition;
attribute vec3 aNormal;
attribute vec3 aTangent;
attribute vec3 aTexCoord;

varying vec4 vPosition;
varying vec3 vNormal;
varying vec3 vTangent;
varying vec3 vBinormal;
varying vec2 vTexCoord;

void main()
{
    vPosition = uModelMatrix*aPosition;
	gl_Position = uProjMatrix*uViewMatrix*vPosition;

    vNormal = normalize(uNormalMatrix*vec4(aNormal, 0)).xyz;
    vTangent = normalize(uNormalMatrix*vec4(aTangent, 0)).xyz;
    vBinormal = cross(vNormal, vTangent);    
	vTexCoord = aTexCoord.xy;
/*
    vPosition = uViewMatrix*uModelMatrix*aPosition;
	gl_Position = uProjMatrix*vPosition;

    vNormal = normalize(uViewMatrix*uNormalMatrix*vec4(aNormal, 0)).xyz;
    vTangent = normalize(uViewMatrix*uNormalMatrix*vec4(aTangent, 0)).xyz;
    vBinormal = cross(vNormal, vTangent);
	vTexCoord = aTexCoord.xy;*/
}

</script>
<script id="fsh_sphere" type="x-shader/x-fragment">
precision mediump float;

const float normalScale = 1.0;
const float ambient = 0.5;
const float envFactor = 0.3;

uniform vec3 uLightPos;
uniform vec3 uEyePos;

uniform sampler2D uSampler0;
uniform sampler2D uSampler1;
uniform samplerCube uSampler2;

varying vec4 vPosition;
varying vec3 vNormal;
varying vec3 vTangent;
varying vec3 vBinormal;
varying vec2 vTexCoord;

void main()
{
                          
    vec3 lightDir = vec3(normalize(vec4(uLightPos, 1.0) - vPosition));

	vec3 bump = texture2D(uSampler1, vTexCoord).xyz;
	bump.xy = (bump.xy*2.0 - 1.0)*normalScale;
    
    vec3 bumpNormal = normalize(vNormal + vTangent*bump.y + vBinormal*bump.x);

    vec3 reflectDir = reflect(normalize(vPosition.xyz - uEyePos), bumpNormal);
	vec3 env = textureCube(uSampler2, reflectDir).xyz;
    
    float NdotL = clamp(dot(bumpNormal, lightDir), 0.0, 1.0);
    
    //vec3 ref = reflect(lightDir, bumpNormal);
    //vec3 eye = normalize(vPosition.xyz - uEyePos);
    //float specular = pow(abs(dot(ref, eye)), 5.0);
    
	vec3 color = texture2D(uSampler0, vTexCoord).xyz;
	gl_FragColor = vec4(color*min(NdotL + ambient, 1.0) + env*envFactor, 1.0);

}

</script>
<script id="vsh_cube" type="x-shader/x-vertex">
uniform mat4 uProjMatrix;
uniform mat4 uModelMatrix;
uniform mat4 uViewMatrix;
uniform mat4 uNormalMatrix;

attribute vec4 aPosition;
attribute vec3 aNormal;
attribute vec3 aTangent;
attribute vec3 aTexCoord;

varying vec4 vPosition;
varying vec3 vNormal;
varying vec3 vTangent;
varying vec3 vBinormal;
varying vec2 vTexCoord;

void main()
{
    vPosition = uModelMatrix*aPosition;
	gl_Position = uProjMatrix*uViewMatrix*vPosition;

    vNormal = normalize(uNormalMatrix*vec4(aNormal, 0)).xyz;
    vTangent = normalize(uNormalMatrix*vec4(aTangent, 0)).xyz;
    vBinormal = cross(vNormal, vTangent);    
	vTexCoord = aTexCoord.xy;
}

</script>
<script id="fsh_cube" type="x-shader/x-fragment">
precision mediump float;

const float normalScale = 0.05;
const float opacity = 0.5;
const float diffuseTexture = 0.0;
const float envFactor = 0.9;
const float specularFactor = 0.15;

uniform vec3 uLightPos;
uniform vec3 uEyePos;

uniform sampler2D uSampler0;
uniform sampler2D uSampler1;
uniform samplerCube uSampler2;

varying vec4 vPosition;
varying vec3 vNormal;
varying vec3 vTangent;
varying vec3 vBinormal;
varying vec2 vTexCoord;

void main()
{

                          
    vec3 lightDir = vec3(normalize(vec4(uLightPos, 1.0) - vPosition));

	vec3 bump = texture2D(uSampler1, vTexCoord).xyz;
	bump.xy = (bump.xy*2.0 - 1.0)*normalScale;
    
    vec3 bumpNormal = normalize(vNormal + vTangent*bump.y + vBinormal*bump.x);
    
    vec3 reflectDir = reflect(normalize(vPosition.xyz - uEyePos), bumpNormal);
	vec3 env = textureCube(uSampler2, reflectDir).xyz;
    
    vec3 ref = reflect(lightDir, bumpNormal);
    vec3 eye = normalize(vPosition.xyz - uEyePos);
    // don't clamp the dot products 'cause transparent object
    float specular = pow(abs(dot(ref, eye)), 5.0);
    
	vec3 color = texture2D(uSampler0, vTexCoord).xyz;
    
	gl_FragColor = vec4(color*diffuseTexture + env*envFactor + vec3(specular)*specularFactor, opacity);
}

</script>

<script id="vsh_skybox" type="x-shader/x-vertex">
uniform mat4 uProjMatrix;
uniform mat4 uModelMatrix;
uniform mat3 uViewMatrix;

attribute vec4 aPosition;
attribute vec3 aTexCoord;

varying vec4 vPosition;
varying vec3 vTexCoord;

void main()
{
    vPosition = uModelMatrix*aPosition;
    mat4 temp = mat4(uViewMatrix[0][0], uViewMatrix[0][1], uViewMatrix[0][2], 0, 
                     uViewMatrix[1][0], uViewMatrix[1][1], uViewMatrix[1][2], 0, 
                     uViewMatrix[2][0], uViewMatrix[2][1], uViewMatrix[2][2], 0, 
                     0, 0, 0, 1); 
                     
    gl_Position = uProjMatrix*temp*vPosition;

	vTexCoord = aTexCoord;
}

</script>
<script id="fsh_skybox" type="x-shader/x-fragment">
precision mediump float;

uniform samplerCube uSampler0;

varying vec4 vPosition;
varying vec3 vTexCoord;

void main()
{
	vec3 env = textureCube(uSampler0, vTexCoord).xyz;
	gl_FragColor = vec4(env, 1.0);
}

</script>
EOT;
}
?>

<?php 
if ($index < 4) {
print <<<EOT
</head>
<body onload="benchmark.init()">

<div id="playground"></div>
<div id="hiddenPlayground"></div>

</body>
</html>
EOT;
}
?>
