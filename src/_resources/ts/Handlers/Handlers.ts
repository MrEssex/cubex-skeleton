class Handler {

    public constructor() {
        for (let handler of this.getHandlers()) {
            new handler();
        }
    }

    protected getHandlers(): Array<any> {
        return [];
    }
}

new Handler()
