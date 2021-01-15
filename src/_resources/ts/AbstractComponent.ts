export abstract class AbstractComponent {
    
    protected componentElement: Element;

    // The Selector this Component Refers to using QuerySelector; e.g .block__element
    public static selector: string;

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
