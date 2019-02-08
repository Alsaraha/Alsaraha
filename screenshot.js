var page = require('webpage').create();
page.viewportSize = { width: 1250, height: 1000 };
page.open('http://ejaaba.com/', function() {
  var clipRect = page.evaluate(function() {
    var r = document.querySelector('.main-panel');
    var l = document.querySelector('.sidebar-panel');
    var p = document.querySelector('.sidebar-panel > .panel');
    var n = document.createElement('div');
    var np = document.createElement('div');

    var br = document.createElement('br');
    var br2 = document.createElement('br');


    n.style.display = "table";

    var svg = document.createElement('svg');
    svg.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 429.657 429.657" style="enable-background:new 0 0 429.657 429.657;" xml:space="preserve"><g>	<g>		<path d="M424.89,112.808l-0.325-0.968c-1.482-4.306-5.611-11.524-16.636-11.524H210.71l-0.046-5.151    c-0.157-17.811-0.65-41.23-3.049-64.473c-0.076-0.739-0.254-1.409-0.414-2.087l-0.302-1.6c-0.566-10.062-9.61-19.22-18.958-19.22    c-4.365,0-8.351,1.978-11.862,5.878L13.418,194.398l-0.998,0.447c-7.64,3.433-12.845,11.705-12.388,19.677l0.021,0.302    l-0.025,0.299c-0.457,7.972,4.748,16.25,12.385,19.677l1,0.447l0.731,0.817l161.934,179.928c3.511,3.899,7.498,5.88,11.862,5.88    c9.354,0,18.392-9.16,18.958-19.215l0.302-1.614c0.16-0.671,0.337-1.346,0.414-2.082c2.399-23.237,2.892-46.657,3.049-64.465    l0.046-5.154h197.218c11.024,0,15.153-7.221,16.636-11.527l0.325-0.965l0.675-0.771c2.717-3.103,4.093-7.019,4.093-11.639V125.218    c0-4.626-1.376-8.541-4.093-11.646L424.89,112.808z M392.527,292.202H198.533c-1.597,0-3.163,0.203-4.946,0.64l-0.62,0.152    l-0.645-0.01c-9.369,0-18.697,5.504-18.702,17.783c0,11.12-0.074,22.226-0.257,33.332l-0.218,13.223L44.896,214.824    l128.25-142.503l0.218,13.223c0.183,11.108,0.257,22.219,0.257,33.337c0.005,12.276,9.333,17.778,18.578,17.778l1.399,0.15    c1.772,0.437,3.344,0.64,4.936,0.64h193.994V292.202z" fill="#D80027"/>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>';

    np.style.display = "table-cell";
    np.style.textAlign = "center";
    np.style.verticalAlign = "200px";
    np.style.color = "red";
    np.style.padding = "8px";

    var t = document.createTextNode("أفضل إجابات");
    var t2 = document.createTextNode((new Date()).toLocaleDateString('ar-EG'));

    np.appendChild(t);
    np.appendChild(br2);
    np.appendChild(t2);
    np.appendChild(br);
    np.appendChild(svg);

    n.appendChild(np);


    var h = p.getBoundingClientRect().height;

    //n.style.backgroundColor = "red";
    n.style.height = h + "px";
    n.style.width = "20%";

    r.style.width = "10%";
    l.style.width = "50%";
    p.style.width = "80%";
    p.style.float = "left";

    l.insertBefore(n, p.nextSibling);
    return document.querySelector('.sidebar-panel').getBoundingClientRect();
  });

  var h = page.evaluate(function() {
    return document.querySelector('.sidebar-panel > .panel').getBoundingClientRect().height;
  });

  page.clipRect = {
    top:    clipRect.top,
    left:   clipRect.left,
    width:  clipRect.width,
    height: h
  };
  page.render('ejaaba.png');
  phantom.exit();
});
