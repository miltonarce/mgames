function ajax(options) {
  let xhr = new XMLHttpRequest();
  let sendBody = null;
  let urlToFetch = options.url;
  let requestMethod = options.method != null ? options.method : "GET";

  if (options.data != null) {
    if (requestMethod.toUpperCase() == "GET") {
      urlToFetch += "?" + options.data;
    } else {
      sendBody = options.data;
    }
  }

  xhr.open(requestMethod, urlToFetch);

  xhr.addEventListener("readystatechange", function() {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        options.successCallback(xhr.responseText);
      } else {
        options.errorCallback();
      }
    }
  });

  if (requestMethod.toUpperCase() == "POST") {
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  }
  xhr.send(sendBody);
}
function $(id) {
  return document.getElementById(id);
}
