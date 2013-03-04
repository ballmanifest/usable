$(function() {
	//initialize docviewer
    var docViewer = new DocViewer({ "id": "DocViewer" });

    //on docviewer ready
    docViewer.ready(function(e) {
        $('.numpages').text(e.numpages);
    });

    //toolbar events
    $('.zoom-in').click(function() {
        docViewer.zoom('in');
    });
    $('.zoom-out').click(function() {
        docViewer.zoom('out');
    });
    $('.prev').click(function() {
        docViewer.scrollTo('prev');
    });
    $('.next').click(function() {
        docViewer.scrollTo('next');
    });

    //docviewer events
    docViewer.bind('pagechange',function(e) {
        $('.num').text(e.page);
    });
});