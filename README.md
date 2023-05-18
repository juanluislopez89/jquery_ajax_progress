![image](https://github.com/juanluislopez89/jquery_ajax_progress/assets/52567376/2af693c2-0001-4c3f-a4cd-857bb10cb689)


# jQuery AJAX Progress
This is a plugin for making recurring AJAX calls to a server, providing feedback on the process in the response of each call. It is designed for situations where, for example, a large number of PDFs need to be generated on the server, compressed into a zip file, and then downloaded, or when thumbnails need to be generated for many images hosted on the server. 

In summary, these processes, on their own, may reach the memory or timeout limit of your server and can be divided into smaller processes. 

The plugin adds a Bootstrap progress bar and a label for process feedback to the content of an HTML element.

### How to setup
```html
<div id="progress_example"></div>
<button type="button" class="btn btn-default" data-target="#progress_example"></button>
```
```javascript
<script>
	$(document).ready(function(){
		$("#progress_example").ajax_progress({
			class : "progress-bar-success",	
			striped: true,
			url: "example.php/repetitive_server_function", 	
			onComplete: function(){
				alert("Done!");
			}
		});
	});
</script>
```


### Server Response Structure

Server side must respond with a JSON response like:

```json
{
	"error": false,
	"total_items": 150,
	"current_item": 75,
	"progress": 50,
	"continue": true
}
```
You have a php example with a valid response in example.php
