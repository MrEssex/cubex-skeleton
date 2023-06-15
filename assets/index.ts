import Calculation from "./ts/calculation";

// import scss
import "./scss/app.scss";

const x = 10;
const y = 20;

console.log(`${x} + ${y} = ${new Calculation().add(x, y)}`);
