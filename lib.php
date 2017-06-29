<?php
/**
 * Lib script.
 *
 * @package local_navblockhacks
 */

/**
 * Attaches the currently active course node to the "Current Course" root node.
 *
 * @param global_navigation $navigation a global_navigation object
 */
function local_navblockhacks_extend_navigation($navigation) {
    global $COURSE, $SITE;

    $course_id = $COURSE->id;
    $course_node = $navigation->find($course_id, global_navigation::TYPE_COURSE);

    if (empty($course_node)) {
        return;
    }

    $current_course_rootnode = $navigation->find('currentcourse', global_navigation::TYPE_ROOTNODE);
    $my_courses_rootnode = $navigation->find('mycourses', global_navigation::TYPE_ROOTNODE);
    $courses_rootnode = $navigation->find('courses', global_navigation::TYPE_ROOTNODE);

    // ACHTUNG MINEN!
    // If the current course is the site-wide default course,
    // we abort processing here without any modifications.
    // Otherwise, this whole hack goes off the rails.
    // [ST 2017/06/29]
    if ($course_id === $SITE->id) {
        return;
    }

    if (!empty($current_course_rootnode)) {
        $current_course_rootnode->forceopen = true;
        $current_course_rootnode->children->add($course_node);
    }

    if (!empty($my_courses_rootnode)) {
        $my_courses_rootnode->forceopen = false;
    }

    if (!empty($courses_rootnode)) {
        $courses_rootnode->forceopen = false;
    }
}
