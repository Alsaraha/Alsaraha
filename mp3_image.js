// controls - just modify these variables
var url = window.location.href;
//var channel = parseInt(prompt("اكتب رقم القناة:")); // 0 = red, 1 = green, 2 = blue
var channel = 0;
var pixw = 1; // pixel width
var pixh = 1; // pixel height
var high = [4, 13]; // [min, max]
var low = [0, 0]; // [min, max]
var title = 's_sound.mp3';
var type = 'audio/mpeg';
//
var canvas = document.createElement('canvas');
var ctx = canvas.getContext('2d');
var img = document.createElement('img');

img.src = url;
canvas.width = img.width;
canvas.height = img.height;
ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

var bytes = [];
var ibit = 0;
var output = "";
for (var y = 0; y < img.height/pixh; y++) {
    for (var x = 0; x < img.width/pixw; x++) {
	ibit++;
	var average = 0;
	var pixelData = ctx.getImageData(0 + x * pixw, 0 +
					 y * pixh, pixw, pixh).data;
	for (var yd = 0; yd < pixh; yd++)
	    for (var xd = 0; xd < pixw; xd++)
		average += pixelData[4*xd+
				     4*
				     yd*pixw+
				     channel];
	average = average/(pixw*pixh);
	if (average >= high[0] && average <= high[1])
	    output += '0';
	else if (average >= low[0] && average <= low[1])
	    output += '1';
	else {
	    //channel = parseInt(prompt("تأكد من رقم القناة - "+pixelData));
	    channel++;
	    if (channel>3)
		alert("لم يتم العثور على قناة");
	    x = img.width/pixw; y = -1; ibit = 0; output = ""; bytes = [];
	    continue;
	}
	if (ibit%8==0) {
	    bytes.push(parseInt(output, 2));
	    output = "";
	}
    }
}

console.log(output.length);

var a = document.createElement('a');
a.download = title;
document.body.appendChild(a);
var sampleBytes = new Int8Array(img.width*img.height/pixw/pixh);
sampleBytes.set(bytes);
var blob = new Blob([sampleBytes], {
    type: type
}),
    url = window.URL.createObjectURL(blob);
a.href = url;
a.click();
