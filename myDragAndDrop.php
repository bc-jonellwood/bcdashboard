<?php
include "./components/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <?php include "./components/sidenav.php" ?>
    <div class='app'>
        <main class='project'>
            <div class='project-info'>
                <h1>Drag and Drop Dash Prototype</h1>
                <div class='project-participants'>
                    <span></span>
                    <span></span>
                    <span></span>
                    <button class='project-participants__add'>Add Participant</button>

                </div>
            </div>
            <div class='project-tasks'>
                <div class='project-column'>
                    <div class='project-column-heading'>
                        <h2 class='project-column-heading__title'>Task Ready</h2><button class='project-column-heading__options'><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--copyright'>Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Create new database for tracking moose migration cycles.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>3</span>
                            <span><i class="fas fa-paperclip"></i>7</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Create new icons that reflect our branding</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>2</span>
                            <span><i class="fas fa-paperclip"></i>5</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--copyright'>Database Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Konsep hero title yang menarik</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>2</span>
                            <span><i class="fas fa-paperclip"></i>3</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>
                </div>
                <div class='project-column'>
                    <div class='project-column-heading'>
                        <h2 class='project-column-heading__title'>In Progress</h2><button class='project-column-heading__options'><i class="fas fa-ellipsis-h"></i></button>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Fix broken links in the footer</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>5</span>
                            <span><i class="fas fa-paperclip"></i>5</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Create and generate the custom SVG UI Designs.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>8</span>
                            <span><i class="fas fa-paperclip"></i>7</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--copyright'>Database Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Generate queries for new tables</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>12</span>
                            <span><i class="fas fa-paperclip"></i>11</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Create the landing page graphics for the hero slider.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>4</span>
                            <span><i class="fas fa-paperclip"></i>8</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                </div>
                <div class='project-column'>
                    <div class='project-column-heading'>
                        <h2 class='project-column-heading__title'>Needs Review</h2><button class='project-column-heading__options'><i class="fas fa-ellipsis-h"></i></button>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--copyright'>Database Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Find all tables comments with curse words in the commments.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>4</span>
                            <span><i class="fas fa-paperclip"></i>0</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>
                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Design the about page.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>0</span>
                            <span><i class="fas fa-paperclip"></i>5</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>
                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--testing'>User Tesing</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Have testing unit test about page.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>0</span>
                            <span><i class="fas fa-paperclip"></i>5</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>
                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Move that one image 5px down to make Chris Happy.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>2</span>
                            <span><i class="fas fa-paperclip"></i>2</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>
                </div>
                <div class='project-column'>
                    <div class='project-column-heading'>
                        <h2 class='project-column-heading__title'>Done</h2><button class='project-column-heading__options'><i class="fas fa-ellipsis-h"></i></button>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Refactor the landing page to include mroe information about cats. We need <b>more</b> cats!</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>12</span>
                            <span><i class="fas fa-paperclip"></i>5</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--design'>UI Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Jerri wants to move the text 3px to the right.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>3</span>
                            <span><i class="fas fa-paperclip"></i>7</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                    <div class='task' draggable='true'>
                        <div class='task__tags'><span class='task__tag task__tag--copyright'>Database Design</span><button class='task__options'><i class="fas fa-ellipsis-h"></i></button></div>
                        <p>Build birthdays API.</p>
                        <div class='task__stats'>
                            <span><time datetime="2021-11-24T20:00:00"><i class="fas fa-flag"></i>Nov 24</time></span>
                            <span><i class="fas fa-comment"></i>8</span>
                            <span><i class="fas fa-paperclip"></i>16</span>
                            <span class='task__owner'></span>
                        </div>
                    </div>

                </div>

            </div>
        </main>
        <aside class='task-details'>
            <div class='tag-progress'>
                <h2>Task Progress</h2>
                <div class='tag-progress'>
                    <p>Database Design <span>3/8</span></p>
                    <progress class="progress progress--copyright" max="8" value="3"> 3 </progress>
                </div>
                <div class='tag-progress'>
                    <p>User Testing <span>6/10</span></p>
                    <progress class="progress progress--testing" max="10" value="3"> 6 </progress>
                </div>
                <div class='tag-progress'>
                    <p>UI Design <span>2/7</span></p>
                    <progress class="progress progress--design" max="11" value="6"> 2 </progress>
                </div>
            </div>
            <div class='task-activity'>
                <h2>Recent Activity</h2>
                <ul>
                    <li>
                        <span class='task-icon task-icon--attachment'><i class="fas fa-paperclip"></i></span>
                        <b>Jerri C </b>uploaded 3 documents
                        <time datetime="2021-11-24T20:00:00">Aug 10</time>
                    </li>
                    <li>
                        <span class='task-icon task-icon--comment'><i class="fas fa-comment"></i></span>
                        <b>Jon E </b>left a comment
                        <time datetime="2021-11-24T20:00:00">Aug 10</time>
                    </li>
                    <li>
                        <span class='task-icon task-icon--edit'><i class="fas fa-pencil-alt"></i></span>
                        <b>Michael G </b>uploaded 3 documents
                        <time datetime="2021-11-24T20:00:00">Aug 11</time>
                    </li>
                    <li>
                        <span class='task-icon task-icon--attachment'><i class="fas fa-paperclip"></i></span>
                        <b>Jeff W </b>uploaded 3 documents
                        <time datetime="2021-11-24T20:00:00">Aug 11</time>
                    </li>
                    <li>
                        <span class='task-icon task-icon--comment'><i class="fas fa-comment"></i></span>
                        <b>Kerri C </b>left a comment
                        <time datetime="2021-11-24T20:00:00">Aug 12</time>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {

        var dragSrcEl = null;

        function handleDragStart(e) {
            this.style.opacity = '0.1';
            this.style.border = '3px dashed #c4cad3';

            dragSrcEl = this;

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }

            e.dataTransfer.dropEffect = 'move';

            return false;
        }

        function handleDragEnter(e) {
            this.classList.add('task-hover');
        }

        function handleDragLeave(e) {
            this.classList.remove('task-hover');
        }

        function handleDrop(e) {
            if (e.stopPropagation) {
                e.stopPropagation(); // stops the browser from redirecting.
            }

            if (dragSrcEl != this) {
                dragSrcEl.innerHTML = this.innerHTML;
                this.innerHTML = e.dataTransfer.getData('text/html');
            }

            return false;
        }

        function handleDragEnd(e) {
            this.style.opacity = '1';
            this.style.border = 0;

            items.forEach(function(item) {
                item.classList.remove('task-hover');
            });
        }


        let items = document.querySelectorAll('.task');
        items.forEach(function(item) {
            item.addEventListener('dragstart', handleDragStart, false);
            item.addEventListener('dragenter', handleDragEnter, false);
            item.addEventListener('dragover', handleDragOver, false);
            item.addEventListener('dragleave', handleDragLeave, false);
            item.addEventListener('drop', handleDrop, false);
            item.addEventListener('dragend', handleDragEnd, false);
        });
    });
</script>
<style>
    :root {
        --bg: #ebf0f7;
        --header: #fbf4f6;
        --text: #2e2e2f;
        --white: #ffffff;
        --light-grey: #c4cad3;
        --tag-1: #ceecfd;
        --tag-1-text: #2e87ba;
        --tag-2: #d6ede2;
        --tag-2-text: #13854e;
        --tag-3: #ceecfd;
        --tag-3-text: #2d86ba;
        --tag-4: #f2dcf5;
        --tag-4-text: #a734ba;
        --purple: #7784ee;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;

    }

    body {
        color: var(--text);
    }

    @mixin display {
        display: flex;
        align-items: center;
    }

    .app {
        background-color: var(--bg);
        width: 100%;
        min-height: 100vh;
    }

    h1 {
        font-size: 30px;
    }

    .project {
        padding: 2rem;
        max-width: 75%;
        width: 100%;
        display: inline-block;
    }

    .project-info {
        padding: 2rem 0;
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .project-participants {
        display: inline-block;
        /* Assuming @include display is inline-block */

    }

    .project-participants span,
    .project-participants__add {
        width: 30px;
        height: 30px;
        display: inline-block;
        background: var(--purple);
        border-radius: 100rem;
        margin: 0 .2rem;
    }

    .project-participants__add {
        background: transparent;
        border: 1px dashed rgb(150, 150, 150);
        font-size: 0;
        cursor: pointer;
        position: relative;
    }

    .project-participants__add:after {
        content: '+';
        font-size: 15px;
        color: rgb(150, 150, 150);
    }

    .project-tasks {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        width: 100%;
        grid-column-gap: 1.5rem;
    }

    .project-column-heading {
        margin-bottom: 1rem;
        display: flex;
        /* Assuming @include display is flex */
        justify-content: space-between;
    }

    .project-column-heading__title {
        font-size: 20px;
    }

    .project-column-heading__options {
        background: transparent;
        color: var(--light-grey);
        font-size: 18px;
        border: 0;
        cursor: pointer;
    }


    .task {
        cursor: move;
        background-color: var(--white);
        padding: 1rem;
        border-radius: 8px;
        width: 100%;
        box-shadow: rgba(99, 99, 99, 0.1) 0px 2px 8px 0px;
        margin-bottom: 1rem;
        border: 3px dashed transparent;
    }

    .task:hover {
        box-shadow: rgba(99, 99, 99, 0.3) 0px 2px 8px 0px;
        border-color: rgba(162, 179, 207, .2) !important;
    }

    .task p {
        font-size: 15px;
        margin: 1.2rem 0;
    }

    .task__tag {
        border-radius: 100px;
        padding: 2px 13px;
        font-size: 12px;
    }

    .task__tag--copyright {
        color: var(--tag-4-text);
        background-color: var(--tag-4);
    }

    .task__tag--design {
        color: var(--tag-3-text);
        background-color: var(--tag-3);
    }

    .task__tag--testing {
        color: var(--tag-2-text);
        background-color: var(--tag-2);
    }

    .task__tags {
        width: 100%;
        display: flex;
        /* Assuming @include display; is for flex display */
        justify-content: space-between;
    }

    .task__options {
        background: transparent;
        border: 0;
        color: var(--light-grey);
        font-size: 17px;
    }

    .task__stats {
        position: relative;
        width: 100%;
        color: var(--light-grey);
        font-size: 12px;
    }

    .task__stats span:not(:last-of-type) {
        margin-right: 1rem;
    }

    .task__stats svg {
        margin-right: 5px;
    }

    .task__owner {
        width: 25px;
        height: 25px;
        border-radius: 100rem;
        background: var(--purple);
        position: absolute;
        display: inline-block;
        right: 0;
        bottom: 0;
    }


    .task-hover {
        border: 3px dashed var(--light-grey) !important;
    }

    .task-details {
        width: 24%;
        border-left: 1px solid #d9e0e9;
        display: inline-block;
        height: 100%;
        vertical-align: top;
        padding: 3rem 2rem;
    }

    .tag-progress {
        margin: 1.5rem 0;

        h2 {
            font-size: 16px;
            margin-bottom: 1rem;
        }

        p {
            display: flex;
            width: 100%;
            justify-content: space-between;

            span {
                color: rgb(180, 180, 180);
            }
        }

        .progress {
            width: 100%;
            -webkit-appearance: none;
            appearance: none;
            border: none;
            border-radius: 10px;
            height: 10px;
        }

        .progress::-webkit-progress-bar,
        .progress::-webkit-progress-value {
            border-radius: 10px;
        }

        .progress--copyright::-webkit-progress-bar {
            background-color: #ecd8e6;
        }

        .progress--copyright::-webkit-progress-value {
            background: #d459e8;
        }

        .progress--UI Design::-webkit-progress-bar {
            background-color: #dee7e3;
        }

        .progress--UI Design::-webkit-progress-value {
            background-color: #46bd84;
        }

        .progress--design::-webkit-progress-bar {
            background-color: #d8e7f4;
        }

        .progress--design::-webkit-progress-value {
            background-color: #08a0f7;
        }
    }

    .task-activity {
        h2 {
            font-size: 16px;
            margin-bottom: 1rem;
        }

        li {
            list-style: none;
            margin: 1rem 0;
            padding: 0rem 1rem 1rem 3rem;
            position: relative;
        }

        time {
            display: block;
            color: var(--light-grey);
        }
    }

    .task-icon {
        width: 30px;
        height: 30px;
        border-radius: 100rem;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        /* Assuming display: flex; is intended */
        justify-content: center;
    }

    .task-icon svg {
        font-size: 12px;
        color: var(--white);
    }

    .task-icon--attachment {
        background-color: #fba63c;
    }

    .task-icon--comment {
        background-color: #5dc983;
    }

    .task-icon--edit {
        background-color: #7784ee;
    }





    @media only screen and (max-width: 1300px) {
        .project {
            max-width: 100%;
        }

        .task-details {
            width: 100%;
            display: flex;
        }

        .tag-progress,
        .task-activity {
            flex-basis: 50%;
            background: var(--white);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem;
        }
    }

    @media only screen and (max-width: 1000px) {

        .project-column:nth-child(2),
        .project-column:nth-child(3) {
            display: none;
        }

        .project-tasks {
            grid-template-columns: 1fr 1fr;
        }
    }



    @media only screen and (max-width: 600px) {
        .project-column:nth-child(4) {
            display: none;
        }

        .project-tasks {
            grid-template-columns: 1fr;
        }

        .task-details {
            flex-wrap: wrap;
            padding: 3rem 1rem;
        }

        .tag-progress,
        .task-activity {
            flex-basis: 100%;
        }

        h1 {
            font-size: 25px;
        }
    }
</style>