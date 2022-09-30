class Calculation {
  public add(x: number, y: number): number {
    return x + y;
  }
}

export default Calculation;

console.log(new Calculation().add(1, 2));
