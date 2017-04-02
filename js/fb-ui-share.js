/*
* FB SETTINGS
*/


  // 1. Get a unique appId for the website from https://developers.facebook.com/apps
  //    The title will be visible in the post, so make it the name of the site (e.g. Taco Truck for Congress)
  // 2. In "Settings", click "+ Add Platform", select "Website", and add the site URL (localhost is cool initially too)
  // 3. In "App Details", things like the icon can be customized

window.fbAsyncInit = function() {
  FB.init({
    appId      : '1886382864928656',
    status     : true,
    xfbml      : true,
    version    : 'v2.8'
  });
  FB.AppEvents.logPageView();
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);

 }(document, 'script', 'facebook-jssdk'));



/*
* FB.UI SHARE EXAMPLE
*/

(function($) {

    // cache the selectors
    // this example assumes there is only one box on a page
    var $fbShareTextarea = $('#header'),
        $fbShareBtn = $('#shareToFacebookButton');
        if (window.console) {
            console.log($fbShareTextarea);
        }

    $fbShareBtn.on('click', function(e) {
        e.preventDefault();
        if (window.console) {
            console.log("FB SHARE CLICKED!!!!");
        }
        // grab the content from the textarea
        var statusText = $fbShareTextarea.val();
        
        // Our settings for FB share dialog box
        // Read more on what these settings mean at https://developers.facebook.com/docs/reference/dialogs/feed/
        var settings = {
                method: "feed",
                name: statusText, // this will be generally truncated at 80 characters
                link: "https://soundcloud.com/stream",
                picture: "https://21centuryedtech.files.wordpress.com/2012/03/wordcloud1.jpg", // This should be at least 200px by 200px. Probably makes sense to use the default OG image
                //caption: "I'm a custom caption", // leave this blank to pull in the domain, otherwise it can be customized
                //description: "I'm a custom description",  // leaving this blank pulls in the og:description tag
                actions: [{name: "LyriCloud", "link": "https://www.facebook.com/"}] // use this to encourage the user's friends to take action
            };

        // FB will generally truncate the name at 80 characters, so if the user's message is longer we will
        // swap the name to a shorter default setting and post the textarea message content in the description area
        if (statusText.length >= 80) {
            settings.name = "I support John Doe";
            settings.description = statusText;
        }

        FB.ui(settings,
            function(response) {
                if (response && response.post_id) {
                    // There will be a response.post_id if the person actually publishes
                    // We could trigger an event to Google Analytics or similar if we wanted to keep track of # of shares
                    // alert('Post was published.')
                } else {
                    // They clicked and opened the dialog box, but did not publish it
                    // alert('Post was not published.');
                }
            }
        );

    });


}(jQuery));