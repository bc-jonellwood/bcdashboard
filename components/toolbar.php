<div class="toolbar">
    <div class="toolbar-item" id="search-by-name">
        <p class="toolbar-tooltip hidden" id="search-by-name-tooptip">Search for employees by name</p>
        <button type="button" class="toolbar-button" popovertarget="employeeLookupPopover" popovertargetaction="show">
            <img src="./icons/person-search.svg" alt="person search icon" class="toolbar-icon" id="employeeSearchTool" />
        </button>
    </div>
    <div class="toolbar-item" id="search-by-department">
        <p class="toolbar-tooltip hidden" id="search-by-department-tooltip">Search for employees by department</p>
        <button type="button" class="toolbar-button" popovertarget="departmentLookupPopover" popovertargetaction="show">
            <img src="./icons/department-search.svg" alt="department search icon" class="toolbar-icon" id="balls" />
        </button>
    </div>
    <div class="toolbar-item" id="search-by-phone">
        <p class="toolbar-tooltip hidden" id="search-by-phone-tooltip">Search for employees by phone number</p>
        <button type="button" class="toolbar-button" popovertarget="phoneLookupPopover" popovertargetaction="show">
            <img src="./icons/phone-light.svg" alt="phone search icon" class="toolbar-icon" id="basket" />
        </button>
    </div>
</div>
<script>
    document.getElementById("search-by-name").addEventListener("mouseenter", function() {
        document.getElementById("search-by-name-tooptip").classList.remove("hidden");
    })

    document.getElementById("search-by-name").addEventListener("mouseleave", function() {
        document.getElementById("search-by-name-tooptip").classList.add("hidden");
    })
    document.getElementById("search-by-department").addEventListener("mouseenter", function() {
        document.getElementById("search-by-department-tooltip").classList.remove("hidden");
    })

    document.getElementById("search-by-department").addEventListener("mouseleave", function() {
        document.getElementById("search-by-department-tooltip").classList.add("hidden");
    })
    document.getElementById("search-by-phone").addEventListener("mouseenter", function() {
        document.getElementById("search-by-phone-tooltip").classList.remove("hidden");
    })

    document.getElementById("search-by-phone").addEventListener("mouseleave", function() {
        document.getElementById("search-by-phone-tooltip").classList.add("hidden");
    })
</script>

<style>
    .toolbar {
        background-color: var(--accent);
        border-radius: 7px;
        border: 2px solid;
        border-color: light-dark(#000, #ffffff20);
        /* color: var(--bg); */
        z-index: 50;
        display: grid;
        gap: 1ex;
        margin: 0;
        text-align: center;
        cursor: pointer;
        user-select: none;
        position: fixed;
        right: 0;
        margin-top: 20%;
        padding-top: 1ex;
        display: grid;
        grid-auto-flow: row;
        grid-auto-columns: 5ch;
        /* overflow-y: auto; */
        /* overscroll-behavior-y: contain; */
        scroll-snap-type: x proximity;
        scroll-padding-inline-start: 2rem;
        border: 1px solid hsl(0 0% 80%);
        /* border-radius: 1ex; */
    }

    .toolbar-icon {
        height: 36px;
        width: 36px;

    }

    .toolbar-icon:hover {
        background-color: var(--accent);
        transform: scale(1.1);
        border-radius: 7px;
        /* margin-top: 10px; */
        /* margin-bottom: 10px; */
        filter: contrast(1.2);
        /* border: 2px solid; */
        /* border-color: var(--fg); */
        /* border-image-source: linear-gradient(to left, #03A9F4, #05DB6C); */
    }

    .toolbar-button {
        background-color: transparent;
        border: none;
        padding: 0;
        margin: 0;
    }

    .toolbar-tooltip {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        background-color: var(--bg);
        color: var(--fg);
        border-radius: 5px;
        padding: 5px;
        font-size: small;
        width: 20ex;
        margin-top: 8ex;
        margin-right: 10ex;
        max-height: fit-content;
        box-shadow: 0px 0px 10px -3px var(--accent);
    }
</style>