const handleImageUpload = (blobInfo, progress) =>
  new Promise((resolve, reject) => {
    const image = blobInfo.blob();

    if (FileReader && image) {
      var fr = new FileReader();
      fr.onload = function () {
        resolve(fr.result);
      };
      fr.readAsDataURL(image);
    }

    // Not supported
    else {
      // fallback -- perhaps submit the input to an iframe and temporarily store
      // them on the server until the user's session ends.
    }
  });
