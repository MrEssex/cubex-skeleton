import {AbstractComponent} from "../AbstractComponent";
import {Loader} from "../Loader";

class ExampleComponent extends AbstractComponent {
    public static selector: string = "body";

    public init(): any {
        console.log(this.getID());
        console.log('hello world');
    }

    public runOnce(): any {
    }
}

new Loader(ExampleComponent);
