import sharp from "sharp";

const SRC = "src/img/geral/og-image.jpg";
const OUT = "public/icons";

// Mobile screenshot (portrait 540x720)
await sharp(SRC)
  .resize(540, 720, { fit: "cover" })
  .jpeg({ quality: 85 })
  .toFile(`${OUT}/screenshot-mobile.jpg`);
console.log("Created screenshot-mobile.jpg (540x720)");

// Desktop screenshot (landscape 1280x720)
await sharp(SRC)
  .resize(1280, 720, { fit: "cover" })
  .jpeg({ quality: 85 })
  .toFile(`${OUT}/screenshot-desktop.jpg`);
console.log("Created screenshot-desktop.jpg (1280x720)");
