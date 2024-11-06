<div class="toolbar">
    <div class="toolbar-item" id="search-by-name">
        <p class="toolbar-tooltip hidden" id="search-by-name-tooptip">Search for employees by name</p>
        <button type="button" class="toolbar-button" popovertarget="employeeLookupPopover" popovertargetaction="show">
            <!-- <img src="./icons/person-search.svg" alt="person search icon" class="toolbar-icon" id="employeeSearchTool" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 toolbar-icon" id="employeeSearchTool" width="24" height="24">
                <path d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M10,4A4,4 0 0,1 14,8C14,8.91 13.69,9.75 13.18,10.43C12.32,10.75 11.55,11.26 10.91,11.9L10,12A4,4 0 0,1 6,8A4,4 0 0,1 10,4M2,20V18C2,15.88 5.31,14.14 9.5,14C9.18,14.78 9,15.62 9,16.5C9,17.79 9.38,19 10,20H2Z" />
            </svg>
        </button>
    </div>
    <div class="toolbar-item" id="search-by-department">
        <p class="toolbar-tooltip hidden" id="search-by-department-tooltip">Search for employees by department</p>
        <button type="button" class="toolbar-button" popovertarget="departmentLookupPopover" popovertargetaction="show">
            <!-- <img src="./icons/department-search.svg" alt="department search icon" class="toolbar-icon" id="balls" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 toolbar-icon" id="balls" width="24" height="24">
                <path d="M19 6V5A2 2 0 0 0 17 3H15A2 2 0 0 0 13 5V6H11V5A2 2 0 0 0 9 3H7A2 2 0 0 0 5 5V6H3V20H11.81A6.5 6.5 0 0 1 21 10.81V6M20.31 17.9A4.5 4.5 0 1 0 18.88 19.32L22 22.39L23.39 21M16.5 18A2.5 2.5 0 1 1 19 15.5A2.5 2.5 0 0 1 16.5 18Z" />
            </svg>
        </button>
    </div>
    <div class="toolbar-item" id="search-by-phone">
        <p class="toolbar-tooltip hidden" id="search-by-phone-tooltip">Search for employees by phone number</p>
        <button type="button" class="toolbar-button" popovertarget="phoneLookupPopover" popovertargetaction="show">
            <!-- <img src="./icons/phone-light.svg" alt="phone search icon" class="toolbar-icon" id="basket" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="bi me-2 toolbar-icon" id="basket">
                <path d="M17 19h2V5h-2zM7 14q.425 0 .713-.288T8 13t-.288-.712T7 12t-.712.288T6 13t.288.713T7 14m0 3q.425 0 .713-.288T8 16t-.288-.712T7 15t-.712.288T6 16t.288.713T7 17m-1-6h8V7H6zm4 3q.425 0 .713-.288T11 13t-.288-.712T10 12t-.712.288T9 13t.288.713T10 14m0 3q.425 0 .713-.288T11 16t-.288-.712T10 15t-.712.288T9 16t.288.713T10 17m3-3q.425 0 .713-.288T14 13t-.288-.712T13 12t-.712.288T12 13t.288.713T13 14m0 3q.425 0 .713-.288T14 16t-.288-.712T13 15t-.712.288T12 16t.288.713T13 17m4 4q-.575 0-1.012-.275T15.275 20H5q-.825 0-1.412-.587T3 18V6q0-.825.588-1.412T5 4h10.275q.275-.45.713-.725T17 3h2q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21z" />
            </svg>
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