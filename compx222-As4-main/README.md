Mozzila has a bug within content-editable containers where the caret doesn't sit where it is meant to
Other browsers do not seem to have this issue

1. After change on an empty container, the caret moves up
2. On focus on a fresh page, the caret starts to the left
3. On a new page with container having content, the caret starts one space too far to the right visually, but computationally it is in the correct place

As a solution, we have just chosen to hide the caret altogether
