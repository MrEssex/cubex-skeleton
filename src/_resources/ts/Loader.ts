import {AbstractComponent} from "./AbstractComponent";

export class Loader {
    constructor(component) {
        const elements: NodeListOf<Element> = document.querySelectorAll(component.selector);

        elements.forEach((element: Element, key: number) => {
            if (elements.hasOwnProperty(key)) {
                let id: string = component.selector + '_' + key;
                element.setAttribute('data-component-id', id);
                let initialize: AbstractComponent = (new component(element));
                if (key === 0) initialize.runOnce();
                initialize.init();
            }
        });

    }
}
