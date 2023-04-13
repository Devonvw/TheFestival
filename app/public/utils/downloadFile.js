//https://stackoverflow.com/questions/50818625/how-can-i-write-a-csv-in-a-file-with-xslx-library-in-node

function downloadFile(content, fileName, mimeType) {
  var a = document.createElement("a");
  mimeType = mimeType || "application/octet-stream";

  if (navigator.msSaveBlob) {
    // IE10
    navigator.msSaveBlob(
      new Blob([content], {
        type: mimeType,
      }),
      fileName
    );
  } else if (URL && "download" in a) {
    //html5 A[download]
    a.href = URL.createObjectURL(
      new Blob([content], {
        type: mimeType,
      })
    );
    a.setAttribute("download", fileName);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  } else {
    location.href =
      "data:application/octet-stream," + encodeURIComponent(content); // only this mime type is supported
  }
}
