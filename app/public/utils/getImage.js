const getImage = (file) => {
  if (!file) return "";
  if (typeof file == "string") return `data:image/jpg;base64, ${file}`;

  //create the preview
  const objectUrl = URL.createObjectURL(file);

  return objectUrl;
};
