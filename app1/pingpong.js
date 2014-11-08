/*
 +-------------------------------------------------------------------+
 |                 J S - P I N G P O N G   (v1.7)                    |
 |                                                                   |
 | Copyright Gerd Tentler               www.gerd-tentler.de/tools    |
 | Created: Jul. 10, 2002               Last modified: Dec. 26, 2010 |
 +-------------------------------------------------------------------+
 | This program may be used and hosted free of charge by anyone for  |
 | personal purpose as long as this copyright notice remains intact. |
 |                                                                   |
 | Obtain permission before selling the code for this program or     |
 | hosting this software on a commercial website or redistributing   |
 | this software over the Internet or in any other medium. In all    |
 | cases copyright must remain intact.                               |
 +-------------------------------------------------------------------+

 This script was tested with the following systems and browsers:

 - Windows XP: IE 6, NN 7, Opera 7 + 9, Firefox 2
 - Mac OS X:   IE 5, Safari 1

 If you use another browser or system, this script may not work for you - sorry.

-----------------------------------------------------------------------------------------------------------

 NOTES:

 - Sound was successfully tested only on Windows with IE 6 and NN 4; Firefox needs a plugin; Opera 7 + 9
   behave very strange when sound is embedded, so for the moment it's disabled for that browser

 - NN 4 on Windows and IE 5 on Mac OS don't view elements (text etc.) below the game area properly; they
   will appear underneath the game area instead

 - IE 5 and Safari 1 on Mac OS show a very poor performance (game is too slow)

 - Movement with arrow keys doesn't work with Opera 7 and NN 4 on Windows and Safari 1 on Mac OS; Safari 1
   and Opera 7 actually don't recognize any key

*/
//---------------------------------------------------------------------------------------------------------
// Configuration
//---------------------------------------------------------------------------------------------------------

var gameMode = 3;                 // 1: all alone, 2: human vs. human, 3: computer vs. human, 4: computer vs. computer
var gameScore = 1;               // maximum score
var gameSpeed = 30;               // speed: 1 - 60 (higher values = slower)
var gameSound = true;             // sound: true = on, false = off
var gameWidth = 400;              // game width (pixels)
var gameHeight = 250;             // game height (pixels)
var gameBorderWidth = 2;          // game border width (pixels)
var gameBorderStyle = "solid";    // game border style ("solid", "dashed", "dotted")
var gameBorderColor = "#60B060";  // game border color

var compHandicap = 2;             // computer handicap: 0 - 4 (higher values = less skilled)

var areaColor = "#008800";        // game area color
var barColor = "#FFFFFF";         // bar color
var ballColor = "#FFFF00";        // ball color
var boxColor = "#60B060";         // dialog-box color

//---------------------------------------------------------------------------------------------------------
// Other variables (don't change from here!)
//---------------------------------------------------------------------------------------------------------

var opera = (navigator.userAgent.indexOf('Opera') != -1) ? true : false;

var mouseY = mousePrev = 0;
var scoreLeft = scoreRight = 0;
var barTimeout = ballTimeout = 0;
var keyPressed = 0;
var actServ = 0;
var audioOn = false;
var gameStop = gameOver = false;

var borderTop = gameBorderWidth + 2;
var borderBottom = gameBorderWidth + gameHeight - 2;
var borderLeft = gameBorderWidth + 2;
var borderRight = gameBorderWidth + gameWidth - 2;

var centerX = Math.round(gameBorderWidth + gameWidth/2);
var centerY = Math.round(gameBorderWidth + gameHeight/2);

var barWidth = Math.round(gameWidth / 30);
var barHeight = Math.round(gameHeight / 6);
var barMove = Math.round(barHeight / 5);
var barHandicap = Math.ceil(compHandicap / 2);
var barPixel = (barHandicap > 0) ? Math.ceil(barMove / barHandicap) : barMove;

var lbarX = gameBorderWidth + 5;
var lbarY = Math.round(centerY - barHeight/2);
var lbar = new makeBar('BarLeft', lbarX, lbarY, barWidth, barHeight, 0, barColor);

var rbarX = gameBorderWidth + gameWidth - barWidth - 5;
var rbarY = lbarY;
var rbar = new makeBar('BarRight', rbarX, rbarY, barWidth, barHeight, 0, barColor);

var ballSize = Math.round(barWidth / 1.5);
var ballPixel = Math.round(gameWidth / 40);
var ballX = Math.round(centerX - ballSize/2);
var ballY = Math.round(centerY - ballSize/2);
var ballMoveX = ballMoveY = 0;
var ball = new makeBar('Ball', ballX, ballY, ballSize, ballSize, ballPixel, ballColor);

if(ballPixel < 1) ballPixel = 1;
if(gameSpeed > 60) gameSpeed = 60;
if(gameSpeed < 1) gameSpeed = 1;
if(compHandicap > 4) compHandicap = 4;
if(compHandicap < 0) compHandicap = 0;

//---------------------------------------------------------------------------------------------------------
// Bar object
//---------------------------------------------------------------------------------------------------------

function makeBar(id, x, y, width, height, pixel, color) {
  this.id = id;
  this.x = x;
  this.y = y;
  this.width = width;
  this.height = height;
  this.pixel = pixel;
  this.color = color;

  this.setPosition = function() {
    var obj = getObj(this.id);
    obj.left = this.x + (document.layers ? '' : 'px');
    obj.top = this.y + (document.layers ? '' : 'px');
    if(obj.pixelLeft != null) obj.pixelLeft = this.x;
    if(obj.pixelTop != null) obj.pixelTop = this.y;
  }

  this.move = function() {
    if(this.y + this.pixel > borderBottom - this.height) this.y = borderBottom - this.height;
    else if(this.y + this.pixel < borderTop) this.y = borderTop;
    else this.y += this.pixel;
    this.setPosition();
  }

  this.build = function() {
    document.write('<div id="' + this.id + '" style="' +
                   'width:' + this.width + 'px; ' +
                   'height:' + this.height + 'px; ' +
                   'background-color:' + this.color + '">' +
                   '<img src="blank.gif" width="' + this.width + '" height="' + this.height + '"/>' +
                   '</div>');
  }
}

//---------------------------------------------------------------------------------------------------------
// Functions
//---------------------------------------------------------------------------------------------------------

if(document.layers) document.captureEvents(Event.MOUSEMOVE|Event.KEYDOWN|Event.KEYUP);
document.onmousemove = getMouseY;
document.onkeydown = getKeyCode;
document.onkeyup = function() { keyPressed = 0; lbar.pixel = 0; }

function getScrollTop() {
  var scrTop = 0;
  if(document.documentElement && document.documentElement.scrollTop)
    scrTop = document.documentElement.scrollTop;
  else if(document.body && document.body.scrollTop)
    scrTop = document.body.scrollTop;
  else if(window.pageYOffset) scrTop = window.pageYOffset;
  return scrTop;
}

function getMouseY(e) {
  if(e && e.pageY) mouseY = e.pageY;
  else if(typeof event != 'undefined') mouseY = event.clientY + getScrollTop();
}

function getKeyCode(e) {
  if(e && e.which) keyPressed = e.which;
  else if(typeof event != 'undefined') keyPressed = event.keyCode;
  if(keyPressed == 110 || keyPressed == 78) newGame();
  else if(keyPressed == 111 || keyPressed == 79) viewOptions();
  else if(keyPressed == 104 || keyPressed == 72) viewHelp();
  else if(keyPressed == 112 || keyPressed == 80) togglePause();
  if(gameMode < 4) {
    if(keyPressed == 38 && rbar.pixel >= 0) rbar.pixel = -barMove;
    else if(keyPressed == 40 && rbar.pixel <= 0) rbar.pixel = barMove;
  }
  if(gameMode == 2) {
    if((keyPressed == 81 || keyPressed == 87 || keyPressed == 113 || keyPressed == 119)
       && lbar.pixel >= 0) lbar.pixel = -barMove;
    else if((keyPressed == 97 || keyPressed == 115 || keyPressed == 65 || keyPressed == 83)
            && lbar.pixel <= 0) lbar.pixel = barMove;
  }
}

function getObj(id) {
  var obj = 0;
  if(document.getElementById && document.getElementById(id)) obj = document.getElementById(id).style;
  else if(document.all && document.all[id]) obj = document.all[id].style;
  else if(document.layers && document.PingPong.document.layers[id]) obj = document.PingPong.document.layers[id];
  return obj;
}

function showHide(id, status) {
  var obj = getObj(id);
  obj.visibility = status;
}

function moveBar(obj, center) {
  var barCenter = Math.round(obj.y + obj.height/2);
  var ballCX = Math.round(ball.x + ballSize/2);
  var ballCY = Math.round(ball.y + ballSize/2);

  if(gameMode != 2) {
    if((obj.x > ballCX && ballMoveX > 0 && ballCX > centerX) ||
       (obj.x < ballCX && ballMoveX < 0 && ballCX < centerX)) {
      if(Math.random() * 8 > barHandicap + 1) {
        if(ballCY > barCenter + ballSize && ballMoveY >= -1) obj.pixel = barPixel;
        else if(ballCY < barCenter - ballSize && ballMoveY <= 1) obj.pixel = -barPixel;
        else obj.pixel = 0;
      }
    }
    else {
      if(obj.y > center + barMove) obj.pixel = -barMove;
      else if(obj.y < center - barMove) obj.pixel = barMove;
      else obj.pixel = 0;
    }
  }
  obj.move();
}

function setBars() {
  if(gameMode < 4) {
    if(mouseY < mousePrev || keyPressed == 38) {
      if(rbar.pixel >= 0) rbar.pixel = -barMove;
      rbar.move();
    }
    else if(mouseY > mousePrev || keyPressed == 40) {
      if(rbar.pixel <= 0) rbar.pixel = barMove;
      rbar.move();
    }
  }
  if(gameMode <= 1) {
    lbar.y = rbar.y;
    lbar.setPosition();
  }
  else {
    if(gameMode >= 2) moveBar(lbar, lbarY);
    if(gameMode >= 4) moveBar(rbar, rbarY);
  }
  mousePrev = mouseY;
  if(!gameStop) {
    if(barTimeout) clearTimeout(barTimeout);
    barTimeout = setTimeout('setBars()', gameSpeed);
  }
}

function initBall() {
  if(ballTimeout) clearTimeout(ballTimeout);
  if(!actServ) {
    if(Math.round(Math.random())) ballMoveX = ballPixel;
    else ballMoveX = -ball.pixel;
  }
  else ballMoveX = ball.pixel * actServ;
  ballMoveY = Math.round(Math.random()) ? 1 : -1;
  ball.x = ballX;
  ball.y = ballY;
  ball.setPosition();
}

function hitBall(obj) {
  var ballTop = ball.y;
  var ballCenter = Math.round(ball.y + ball.height/2);
  var ballBottom = ball.y + ball.height;
  var barCenter = Math.round(obj.y + obj.height/2);

  if(ballBottom + ball.pixel < borderBottom && ballTop - ball.pixel > borderTop) {
    if(ballCenter < barCenter - obj.height/2) ballMoveY = Math.ceil(-ball.pixel*1.5);
    else if(ballCenter > barCenter + obj.height/2) ballMoveY = Math.ceil(ball.pixel*1.5);
    else if(ballCenter < barCenter - obj.height/4) ballMoveY = -ball.pixel;
    else if(ballCenter > barCenter + obj.height/4) ballMoveY = ball.pixel;
    else if(ballCenter < barCenter - obj.height/6) ballMoveY = Math.ceil(-ball.pixel/2);
    else if(ballCenter > barCenter + obj.height/6) ballMoveY = Math.ceil(ball.pixel/2);
    else ballMoveY = ballCenter < barCenter ? -1 : 1;
  }
  if(gameSound) playSound('sndHit');
}

function moveBall() {
  var speed = gameSpeed;
  var left = lbar.x + lbar.width;
  var right = rbar.x - ball.width;
  var ballBottom = ball.y + ball.height;

  if(ball.x <= borderLeft) {
    scoreRight++;
    setScore('ScoreRight');
    speed = 1000;
  }
  else if(ball.x + ball.width >= borderRight) {
    scoreLeft++;
    setScore('ScoreLeft');
    speed = 1000;
  }
  else {
    ball.x += ballMoveX;
    ball.y += ballMoveY;
    ball.setPosition();
    if(ball.y <= borderTop || ball.y + ball.height >= borderBottom) ballMoveY *= -1;
    else if(ball.x <= left && ballBottom >= lbar.y && ball.y <= lbar.y + lbar.height) {
      ballMoveX = ball.pixel;
      hitBall(lbar);
    }
    else if(ball.x >= right && ballBottom >= rbar.y && ball.y <= rbar.y + rbar.height) {
      ballMoveX = -ball.pixel;
      hitBall(rbar);
    }
  }
  if(!gameStop) {
    if(ballTimeout) clearTimeout(ballTimeout);
    ballTimeout = setTimeout('moveBall()', speed);
  }
}

function setScore(div) {
  if(div == 'ScoreLeft') {
    var score = scoreLeft;
    actServ = 1;
  }
  else {
    var score = scoreRight;
    actServ = -1;
  }
  if(document.getElementById) document.getElementById(div).innerHTML = score;
  else if(document.all) document.all[div].innerHTML = score;
  else if(document.layers) {
    document.PingPong.document.layers[div].document.write(score);
    document.PingPong.document.layers[div].document.close();
  }
  if(gameSound && score) playSound('sndScore');
  if(score < gameScore) initBall();
  else endGame();
}

function hideInfo(id) {
  showHide(id, 'hidden');
  if(!gameOver) {
    gameStop = false;
    if(barTimeout) setBars();
    if(ballTimeout) moveBall();
  }
}

function viewOptions() {
  var f = document.layers ? document.PingPong.document.Options.document.opt : document.opt;
  gameStop = true;
  f.Mode.selectedIndex = gameMode - 1;
  f.Sound.selectedIndex = gameSound ? 0 : 1;
  f.Speed.selectedIndex = gameSpeed < 10 ? 0 : Math.round(gameSpeed/10);
  f.Handicap.selectedIndex = compHandicap;
  showHide('Help', 'hidden');
  showHide('Options', 'visible');
}

function setOptions() {
  var f = document.layers ? document.PingPong.document.Options.document.opt : document.opt;
  gameMode = f.Mode.options[f.Mode.selectedIndex].value;
  gameSound = f.Sound.selectedIndex ? false : true;
  gameSpeed = f.Speed.options[f.Speed.selectedIndex].value;
  compHandicap = f.Handicap.options[f.Handicap.selectedIndex].value;
  barHandicap = Math.ceil(compHandicap / 2);
  barPixel = (barHandicap > 0) ? Math.ceil(barMove / barHandicap) : barMove;
  hideInfo('Options');
}

function viewHelp() {
  gameStop = true;
  showHide('Options', 'hidden');
  showHide('Help', 'visible');
}

function togglePause() {
  if(!gameOver) {
    gameStop = gameStop ? false : true;
    if(!gameStop) {
      showHide('Options', 'hidden');
      showHide('Help', 'hidden');
      if(barTimeout) {
        clearTimeout(barTimeout);
        setBars();
      }
      if(ballTimeout) {
        clearTimeout(ballTimeout);
        moveBall();
      }
    }
  }
}

function endGame() {
  gameStop = gameOver = true;
  showHide('GameOver', 'visible');
  
 
var socket = new io.Socket('localhost',{
	port: 80
});
socket.connect(); 

// Add a connect listener
socket.on('connect',function() {
	console.log('Client has connected to the server!');
});
// Add a connect listener
socket.on('message',function(data) {
	console.log('Received a message from the server!',data);
});
// Add a disconnect listener
socket.on('disconnect',function() {
	console.log('The client has disconnected!');
});

// Sends a message to the server via sockets
function sendMessageToServer(message) {
	socket.send(message);
}
}

function newGame() {
  if(barTimeout) clearTimeout(barTimeout);
  if(ballTimeout) clearTimeout(ballTimeout);
  scoreLeft = scoreRight = 0;
  gameStop = gameOver = false;
  showHide('GameOver', 'hidden');
  showHide('Options', 'hidden');
  showHide('Help', 'hidden');
  setScore('ScoreLeft');
  setScore('ScoreRight');
  setBars();
  initBall();
  if(ballTimeout) clearTimeout(ballTimeout);
  ballTimeout = setTimeout('moveBall()', 1000);
}

function playSound(id) {
  if(audioOn) {
    if(document.getElementById) var snd = document.getElementById(id);
    else var snd = eval('document.' + id);

    if(snd != null) {
      if(typeof snd.play == 'function') snd.play();
	  else if(typeof snd.Play == 'function') snd.Play();
      else if(typeof snd.doPlay == 'function') snd.doPlay();
      else if(document.all) {
        if(document.M == null) {
          document.M = false;
          for(var m in snd) if(m == 'ActiveMovie') {
            document.M = true;
            break;
          }
        }
        if(document.M) {
          snd.SelectionStart = 0;
          snd.play();
        }
      }
    }
  }
}

window.onload = function() { audioOn = true; }

//---------------------------------------------------------------------------------------------------------
// Build game
//---------------------------------------------------------------------------------------------------------

document.write('<style> ' +
               '#PingPong { position: relative' +
               '; width: ' + (gameWidth + gameBorderWidth*2) + 'px' +
               '; height: ' + (gameHeight + gameBorderWidth*2) + 'px' +
               '; } ' +
               '#GameArea { position: absolute' +
               '; top: 0px' +
               '; left: 0px' +
               '; border-style: ' + gameBorderStyle +
               '; border-width: ' + gameBorderWidth + 'px' +
               '; border-color: ' + gameBorderColor +
               '; } ' +
               '#ScoreLeft { position: absolute' +
               '; top: ' + borderTop + 'px' +
               '; left: ' + Math.floor(centerX - gameWidth/4) + 'px' +
			   '; font-family: Verdana, Arial, Helvetica' +
			   '; font-size: ' + Math.round(gameWidth / 20) + 'px' +
			   '; font-weight: bold' +
			   '; color: ' + barColor +
               '; } ' +
               '#ScoreRight { position: absolute' +
               '; top: ' + borderTop + 'px' +
               '; left: ' + Math.floor(centerX + gameWidth/4) + 'px' +
			   '; font-family: Verdana, Arial, Helvetica' +
			   '; font-size: ' + Math.round(gameWidth / 20) + 'px' +
			   '; font-weight: bold' +
			   '; color: ' + barColor +
               '; } ' +
               '#Menu { position: absolute' +
               '; top: ' + (borderBottom - 20) + 'px' +
               '; left: ' + (centerX - 102) + 'px' +
               '; color: ' + barColor +
               '; } ' +
               '#GameOver { position: absolute; visibility:hidden' +
               '; top: ' + Math.round(centerY - gameWidth/20) + 'px' +
               '; left: ' + Math.round(centerX - gameWidth/3.5) + 'px' +
               '; color: ' + barColor +
               '; font-family: Comic Sans MS' +
               '; font-size: ' + Math.round(gameWidth/15) + 'px' +
               '; } ' +
               '#Options { position: absolute; visibility:hidden' +
               '; top: ' + (centerY - 58) + 'px' +
               '; left: ' + (centerX - 106) + 'px' +
               '; z-index:1; } ' +
               '#Help { position: absolute' +
               '; top: ' + (centerY - 63) + 'px' +
               '; left: ' + (centerX - 105) + 'px' +
               '; z-index: 1; } ' +
               '#BarLeft { position: absolute' +
               '; top: ' + lbar.y + 'px' +
               '; left: ' + lbar.x + 'px' +
               '; z-index: 0; } ' +
               '#BarRight { position: absolute' +
               '; top: ' + rbar.y + 'px' +
               '; left: ' + rbar.x + 'px' +
               '; z-index: 0; } ' +
               '#Ball { position: absolute' +
               '; top: ' + ball.y + 'px' +
               '; left: ' + ball.x + 'px' +
               '; z-index: 0; } ' +
               '.cssA, .cssA:visited, .cssA:active, .cssA:hover { text-decoration: none' +
               '; font-family: MS Sans Serif, sans-serif; font-size: 12px' +
               '; color: ' + barColor +
               '; } ' +
               '.cssTD { font-family: MS Sans Serif, sans-serif; font-size: 12px' +
               '; color: ' + barColor +
               '; } ' +
               '.cssForm { font-family: MS Sans Serif, sans-serif; font-size: 12px; } ' +
               '</style>');

document.write('<div id="PingPong">');

document.write('<div id="GameArea">' +
               '<table cellspacing="0" cellpadding="0" border="0"' +
               ' width="' + gameWidth + '"' +
               ' height="' + gameHeight + '"' +
               ' bgcolor="' + areaColor + '"' +
               '><tr><td class="cssTD" align="center"><table border="0" cellspacing="0" cellpadding="0">' +
               '<tr><td class="cssTD" bgcolor="' + boxColor + '"' +
               '><img src="blank.gif"' +
               ' width="' + gameBorderWidth + '"' +
               ' height="' + gameHeight + '"' +
               '></td></tr></table></td></tr></table>' +
               '</div>');

document.write('<div id="ScoreLeft"></div>');

document.write('<div id="ScoreRight"></div>');

document.write('<div id="Menu">' +
               '[ <a href="javascript:viewOptions()" class="cssA" onFocus="this.blur()"><u>O</u>ptions</a> | ' +
               '<a href="javascript:viewHelp()" class="cssA" onFocus="this.blur()"><u>H</u>elp</a> | ' +
               '<a href="javascript:togglePause()" class="cssA" onFocus="this.blur()"><u>P</u>ause</a> | ' +
               '<a href="javascript:newGame()" class="cssA" onFocus="this.blur()"><u>N</u>ew Game</a> ]' +
               '</div>');

document.write('<div id="GameOver">G A M E &nbsp; O V E R</div>');

document.write('<div id="Options">' +
               '<table border="0" cellspacing="0" cellpadding="2" bgcolor="' + boxColor + '">' +
               '<form name="opt">' +
               '<tr><td class="cssTD">Mode:</td><td class="cssTD"><select name="Mode" class="cssForm">' +
               '<option value="1">play all alone' +
               '<option value="2">human vs. human' +
               '<option value="3">computer vs. human' +
               '<option value="4">computer vs. computer' +
               '</select></td></tr>' +
               '<tr><td class="cssTD">Sound:</td><td class="cssTD"><select name="Sound" class="cssForm">' +
               '<option>on' +
               '<option>off' +
               '</select></td></tr>' +
               '<tr><td class="cssTD">Game Speed:</td><td class="cssTD"><select name="Speed" class="cssForm">' +
               '<option value="1">ultra fast' +
               '<option value="10">very fast' +
               '<option value="20">fast' +
               '<option value="30">medium' +
               '<option value="40">slow' +
               '<option value="50">very slow' +
               '<option value="60">ultra slow' +
               '</select></td></tr>' +
               '<tr><td class="cssTD">Computer Skill:</td><td class="cssTD"><select name="Handicap" class="cssForm">' +
               '<option value="0">very good' +
               '<option value="1">good' +
               '<option value="2">medium' +
               '<option value="3">poor' +
               '<option value="4">very poor' +
               '</select></td></tr>' +
               '<tr><td class="cssTD"><input type="button" value="Cancel" class="cssForm" onClick="hideInfo(\'Options\')">' +
               '<td class="cssTD" align="right"><input type="button" value="&nbsp; OK &nbsp;" class="cssForm" onClick="setOptions()">' +
               '</td></tr>' +
               '</form></table>' +
               '</div>');

document.write('<div id="Help">' +
               '<table border="0" cellspacing="0" cellpadding="2" bgcolor="' + boxColor + '">' +
               '<form><tr><td class="cssTD" colspan="2" align="center"><b>Ping Pong</b></td></tr>' +
               '<tr><td class="cssTD" colspan="2" align="center">(by Gerd Tentler)</td></tr>' +
               '<tr><td class="cssTD">right bar up:</td><td class="cssTD">mouse up or arrow up</td></tr>' +
               '<tr><td class="cssTD">right bar down:</td><td class="cssTD">mouse down or arrow down</td></tr>' +
               '<tr><td class="cssTD">left bar up:</td><td class="cssTD">Q or W</td></tr>' +
               '<tr><td class="cssTD">left bar down:</td><td class="cssTD">A or S</td></tr>' +
               '<tr><td class="cssTD" colspan="2" align="center">' +
               '<input type="button" value="&nbsp; OK &nbsp;" class="cssForm" onClick="hideInfo(\'Help\')">' +
               '</td></tr></form></table>' +
               '</div>');

lbar.build();
rbar.build();
ball.build();

document.write('</div>');

//---------------------------------------------------------------------------------------------------------
// Sounds (with Opera it doesn't work properly - who knows why?)
//---------------------------------------------------------------------------------------------------------

if(!opera) {
  document.write('<embed name="sndHit" id="sndHit" src="snd_hit.wav" mastersound loop="false" ' +
                 'autostart="false" autorewind="true" enablejavascript="true" width="0" height="0">');
  document.write('<embed name="sndScore" id="sndScore" src="snd_score.wav" mastersound loop="false" ' +
                 'autostart="false" autorewind="true" enablejavascript="true" width="0" height="0">');
}

//---------------------------------------------------------------------------------------------------------

