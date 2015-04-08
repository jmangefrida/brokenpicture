<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
<body>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1577501469203645',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.2' // use version 2.2
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>
Product Docs
Ads for Apps
Ads for Websites
App Events
App Links
Audience Network
Games
Insights
Login

    Overview
    iOS
    Android
    Web
        Login Button
    Windows Phone
    Permissions
    Access Tokens
    Send to Mobile
    Testing
    Best Practices
    Advanced

Marketing API
Payments for Games
Sharing
Social Plugins
App Development
APIs and SDKs
Graph API
iOS SDK
Android SDK
JavaScript SDK
PHP SDK
Unity SDK
Facebook Login Version
v2.2
Facebook Login for the Web with the JavaScript SDK

Facebook apps can use one of several login flows, depending on the target device and the project. This guide takes you step-by-step through the login flow for web apps. The steps in this guide use Facebook's JavaScript SDK, which is the recommended method to add Facebook Login to your website.

If for some reason you can't use our JavaScript SDK you can also implement login without it. We've build a separate guide to follow if you need to implement login manually.
Quickstart

Later in this doc we will guide you through the login flow step-by-step and explain each step clearly - this will help you if you are trying to integrate Facebook Login into an existing login system, or just to integrate it with any server-side code you're running. But before we do that, it's worth showing how little code is required to implement login in a web application using the JavaScript SDK.

You will need a Facebook App ID before you start using the SDK, which you can create and retrieve on the App Dashboard. You'll also need somewhere to host HTML files. If you don't have hosting, you can get set up quickly with Parse.

This code will load and initialize the JavaScript SDK in your HTML page. Use your app ID where indicated.

<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
<body>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '{your-app-id}',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.2' // use version 2.2
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

</body>
</html>

Now you can test your app by going to the URL where you uploaded this HTML. Open your JavaScript console, and you'll see the testAPI() function display a message with your name in the console log.

Congratulations, at this stage you've actually built a really basic page with Facebook Login. You can use this as the starting point for your own app, but it will be useful to read on and understand what is happening in the code above.
Steps for Using Facebook Login With the JavaScript SDK

There are a few steps that you will need to follow to integrate Facebook Login into your web application, most of which are included in the quickstart example at the top of this page. At a high level those are:

    Checking the login status to see if someone's already logged into your app. During this step, you also should check to see if someone has previously logged into your app, but is not currently logged in.
    If they are not logged in, invoke the login dialog and ask for a set of data permissions.
    Verify their identity.
    Store the resulting access token.
    Make API calls.
    Log out.

Checking login status

The first step when loading your web page is figuring out if a person is already logged into your app with Facebook login. You start that process with a call to FB.getLoginStatus. That function will trigger a call to Facebook to get the login status and call your callback function with the results.

Taken from the sample code above, here's some of the code that's run during page load to check a person's login status:

FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});

The response object that's provided to your callback contains a number of fields:

{
    status: 'connected',
    authResponse: {
        accessToken: '...',
        expiresIn:'...',
        signedRequest:'...',
        userID:'...'
    }
}

    status specifies the login status of the person using the app. The status can be one of the following:
        connected. The person is logged into Facebook, and has logged into your app.
        not_authorized. The person is logged into Facebook, but has not logged into your app.
        unknown. The person is not logged into Facebook, so you don't know if they've logged into your app.
    authResponse is included if the status is connected and is made up of the following:
        accessToken. Contains an access token for the person using the app.
        expiresIn. Indicates the UNIX time when the token expires and needs to be renewed.
        signedRequest. A signed parameter that contains information about the person using the app.
        userID is the ID of the person using the app.

Once your app knows the login status of the person using it, it can do one of the following:

    If the person is logged into Facebook and your app, redirect them to your app's logged in experience.
    If the person isn't logged into your app, or isn't logged into Facebook, prompt them with the Login dialog with FB.login() or show them the Login Button.

Logging people in

If people using your app aren't logged into your app or not logged into Facebook, you can use the Login dialog to prompt them to do both. Various versions of the dialog are shown below.

If they aren't logged into Facebook, they'll first be prompted to log in and then move on to logging in to your app. The JavaScript SDK automatically detects this, so you don't need to do anything extra to enable this behavior.

There are two ways to log someone in:

    Use the Login Button.
    Use FB.login() from the JavaScript SDK.

Using the Login Button

Including the Login Button into your page is easy. Visit the documentation for the login button and set the button up the way you want. Then click Get Code and it will show you the code you need to display the button on your page.

Note that in the example at the start of this document, we use the onlogin attribute on the button to set up a JavaScript callback that checks the login status to see if the person logged in successfully:

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

This is the callback. It calls FB.getLoginStatus() to get the most recent login state. (statusChangeCallback() is a function that's part of the example that processes the response.)

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

Invoking the Login Dialog with the JavaScript SDK

For apps that want to use their own button, you can invoke the Login Dialog with a simple call to FB.login():

FB.login(function(response){
  // Handle the response object, like in statusChangeCallback() in our demo
  // code.
});

As noted in the reference docs for this function, it results in a popup window showing the Login dialog, and therefore should only be invoked as a result of someone clicking an HTML button (so that the popup isn't blocked by browsers).

There is an optional scope parameter that can be passed along with the function call that is a comma separated list of permissions to request from the person using the app. Here's how you would call FB.login() with the same scope as the Login Button we used above. In this case, it would ask for a person's email address and a list of friends who also use the app:

 FB.login(function(response) {
   // handle the response
 }, {scope: 'public_profile,email'});

Handling Login dialog response

At this point in the login flow, your app displays the Login dialog, which gives people the choice of whether to cancel or to enable the app to access their data.

Whatever choice people make, the browser returns to the app and response data indicating whether they connected or cancelled is sent to your app. When your app uses the JavaScript SDK, it returns an authResponse object to the callback specified when you made the FB.login() call:

This response can be detected and handled within the FB.login call, like this:

FB.login(function(response) {
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
  } else if (response.status === 'not_authorized') {
    // The person is logged into Facebook, but not your app.
  } else {
    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
  }
});

Asking for Permissions

One of the most important parts of launching the Login Dialog is choosing what data your app would like access to. These examples have all used the scope parameter, which is how you ask for access to someone's data. These are all called Permissions.

Permissions are covered in depth in our permissions guide. However, there are a few things to remember when dealing with permissions and the login dialog:

    You ask for permissions when the dialog is created. The resulting set of permissions is tied to the access token that's returned.
    Other platforms may have a different set of permissions. For example, on iOS you can ask for places a person's been tagged, while in the web version of your app that permission is not required for the experience.
    You can add permissions later when you need more capabilities. When you need a new permission, you simply add the permission you need to the list you've already granted, re-launch the Login Dialog and it will ask for the new permission.
    The Login Dialog lets people decline to share certain permissions with your app that you ask for. Your app should handle this case. Learn more about this in our permissions dialog.
    Apps that ask for more than public_profile, email and user_friends must be reviewed by Facebook before they can be made available to the general public. Learn more in our documentation for login review and our general review guidelines.

Storing Access Tokens

At the end of the login process, an access token is generated. This access token is the thing that's passed along with every API call as proof that the call was made by a specific person from a specific app.

The Facebook SDK for JavaScript automatically handles access token storage and tracking of login status in the browser, so nothing is needed for you to store access tokens in the browser itself.

However, a common pattern is to take the access token and pass it back to a server and the server makes calls on behalf of a person. In order to get the token from the browser you can use the response object that's returned via FB.getLoginStatus():

FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    console.log(response.authResponse.accessToken);
  }
});

The token is an opaque string of variable length.

Also keep in mind that the access tokens that are generated in browsers generally have a lifetime of only a couple of hours and are automatically refreshed by the JavaScript SDK. If you are making calls from a server, you will need to generate a long lived token, which is covered at length in our access token documentation.
Verifying identity

Apps normally need to confirm that the response from the Login dialog was made from the same person who started it. If you're using Facebook's JavaScript SDK it automatically performs these checks so nothing is required, assuming that you're only making calls from the browser.

If you decide to send it back to the server, you should make sure you re-verify the access token once it gets to the server. Re-verifying the token is covered in our documentation on manually building login flows. You'll need to verify that the app_id and user_id match what you expected from the access token debug endpoint.
Make API calls

At this point in the flow, the person is authenticated and logged in. Your app is now ready to make API calls on their behalf from the browser. In the browser, the easiest way to do that is with the FB.api() call. FB.api() will automatically add the access token to the call.

This code:

FB.api('/me', function(response) {
    console.log(JSON.stringify(response));
});

Will return an array of values:

{
  "id":"101540562372987329832845483",
  "email":"example@example.com",
  "first_name":"Bob",
  [ ... ]
}

If you're making calls server side with the access token, you can use an SDK on the server to make similar calls. Many people use PHP to build web applications. You can find some examples of making server-side API calls in our PHP SDK documentation.
Logging people out

You can log people out of your app by attaching the JavaScript SDK function FB.logout to a button or a link, as follows:

    FB.logout(function(response) {
        // Person is now logged out
    });

Note: This function call will also log the person out of Facebook. The reason for this is that someone may have logged into your app and into Facebook during the login flow. If this is the case, they might not expect to still be logged into Facebook when they log out of your app. To
<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

</body>
</html>