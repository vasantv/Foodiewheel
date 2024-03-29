// JavaScript Document
/* spin-wheel code sourced and adapted from http://www.switchonthecode.com/tutorials/creating-a-roulette-wheel-using-html5-canvas */

var colors = ["#B8D430", "#3AB745", "#029990", "#3501CB","#2E2C75","#673A7E","#CC0071","#F80120","#F35B20", "#FB9A00", "#FFCC00", "#FEF200"];

var numChoices = 10;
var startAngle = 0;
var arc = Math.PI / (numChoices/2);
var spinTimeout = null;

var spinArcStart = 10;
var spinTime = 0;
var spinTimeTotal = 0;

var ctx;
var text;

function drawRouletteWheel() {
  var canvas = document.getElementById("mealwheel");
  if (canvas.getContext) {
    var outsideRadius = 200;
    var textRadius = 150;
    var insideRadius = 100;
    
    ctx = canvas.getContext("2d");
    ctx.clearRect(0,0,450,450);
    
    
    ctx.strokeStyle = "white";
    ctx.lineWidth = 2;
    
    ctx.font = 'bold 12px Helvetica, Verdana, Arial, Calibri';
    
    for(var i = 0; i < numChoices; i++) {
      var angle = startAngle + i * arc;
      ctx.fillStyle = colors[i];
      
      ctx.beginPath();
      ctx.arc(225, 225, outsideRadius, angle, angle + arc, false);
      ctx.arc(225, 225, insideRadius, angle + arc, angle, true);
      ctx.stroke();
      ctx.fill();
      
      ctx.save();
      //ctx.shadowOffsetX = 0;
      //ctx.shadowOffsetY = 0;
      //ctx.shadowBlur    = 0;
      //ctx.shadowColor   = "rgb(220,220,220)";
	  ctx.strokeStyle = "rgba(255,255,255,0.4)";
	  ctx.lineWidth = 3;
      ctx.translate(225 + Math.cos(angle + arc / 2) * textRadius, 
                    225 + Math.sin(angle + arc / 2) * textRadius);
      ctx.rotate(angle + arc / 2 + Math.PI / 2);
	  text = foodChoices[i];     
      ctx.strokeText(text, -ctx.measureText(text).width / 2, 0);

      ctx.fillStyle = "black";
	  ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
	  ctx.restore();
    } 
    
    //Arrow
    ctx.fillStyle = "green";
    ctx.beginPath();
    ctx.moveTo(225 - 10, 225 - (outsideRadius + 20));
    ctx.lineTo(225 + 10, 225 - (outsideRadius + 20));
    ctx.lineTo(225 + 10, 225 - (outsideRadius - 5));
    ctx.lineTo(225 + 20, 225 - (outsideRadius - 5));
    ctx.lineTo(225 + 0, 225 - (outsideRadius - 20));
    ctx.lineTo(225 - 20, 225 - (outsideRadius - 5));
    ctx.lineTo(225 - 10, 225 - (outsideRadius - 5));
    ctx.lineTo(225 - 10, 225 - (outsideRadius + 5));
    ctx.fill();
  }
}
    
function spin() {
  spinAngleStart = Math.random() * 10 + 10;
  spinTime = 0;
  spinTimeTotal = Math.random() * 3 + 4 * 1000;
  rotateWheel();
}

function rotateWheel() {
  spinTime += 30;
  if(spinTime >= spinTimeTotal) {
    stopRotateWheel();
    return;
  }
  var spinAngle = spinAngleStart - easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
  startAngle += (spinAngle * Math.PI / 180);
  drawRouletteWheel();
  spinTimeout = setTimeout('rotateWheel()', 30);
}

function stopRotateWheel() {
  clearTimeout(spinTimeout);
  var degrees = startAngle * 180 / Math.PI + 90;
  var arcd = arc * 180 / Math.PI;
  var index = Math.floor((360 - degrees % 360) / arcd);
  ctx.save();
  ctx.font = 'bold 30px Helvetica, Arial';
  text = foodChoices[index]
  ctx.fillText(text, 225 - ctx.measureText(text).width / 2, 225 + 10);

  _gaq.push(['_trackEvent', 'wheelspin', 'spinresult', text]);
  $('#info_callout').show("slow").html("Result: "+text+'<b class="notch"></b>');
  ctx.restore();
}

function easeOut(t, b, c, d) {
  var ts = (t/=d)*t;
  var tc = ts*t;
  return b+c*(tc + -3*ts + 3*t);
}