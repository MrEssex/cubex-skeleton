export abstract class AbstractComponent {
    public static selector: string;
    protected componentElement: Element;

    public constructor(element: Element) {
        this.componentElement = element;
        return this;
    }

    getID(): string {
        return this.componentElement.getAttribute('data-component-id');
    }

    public abstract runOnce(): any;

    public abstract init(): any;
}
