const getImage = (file) => {
  if (typeof file == "string") return `data:image/jpg;base64, ${file}`;
  if (typeof file == "blob") return `data:image/jpg;base64, ${file}`;

  //create the preview
  const objectUrl = URL.createObjectURL(file);

  return objectUrl;
};
