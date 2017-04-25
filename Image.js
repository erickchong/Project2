function GetImage(button, cloud, destination) {
	document.getElementById(button).onclick = function() {
    var wordcloud = document.getElementById(cloud);
    
    html2canvas(wordcloud, {
      onrendered: function(canvas) {
        var image = canvas.toDataURL(destination);
        window.open(image);
      }
    });
  }
}

