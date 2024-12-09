 set of children
        $result = array();

        // a little sanity check to make sure it's not ALL whitespace
        $all_whitespace = true;

        $current_li = null;

        foreach ($children as $node) {
            if (!empty($node->is_whitespace)) {
                $result[] = $node;
                continue;
            }
            $all_whitespace = false; // phew, we're not talking about whitespace

            if ($node->name === 'li') {
                // good
                $current_li = $node;
                $result[] = $node;
            } else {
                // we want to tuck this into the previous li
                // Invariant: we expect the node to be ol/ul
                // ToDo: Make this more robust in the case of not ol/ul
                // by distinguishing between existing li and li created
                // to handle non-list elements; non-list elements should
                // not be appended to an existing li; only li created
                // for non-list. This distinction is not currently made.
                if ($current_li === null) {
                    $current_li = new HTMLPurifier_Node_Element('li');
                    $result[] = $current_li;
                }
                $current_li->children[] = $node;
                $current_li->empty = false; // XXX fascinating! Check for this error elsewhere ToDo
            }
        }
        if (empty($result)) {
            return false;
        }
        if ($all_whitespace) {
            return false;
        }
        return $result;
    }
}

// vim: et sw=4 sts=4
