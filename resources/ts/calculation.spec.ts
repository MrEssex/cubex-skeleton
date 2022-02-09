import Calculation from "./calculation"; // this will be your custom import
import {expect} from 'chai';

describe('Calculator tests', () => { // the tests container
    it('checking add function', () => { // the single test
        const calc = new Calculation(); // this will be your class

        expect(calc.add(1, 2)).to.be.equal(3);
    });
});
