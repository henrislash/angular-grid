<?php
$key = "Datasource";
$pageTitle = "Angular Grid Datasource";
$pageDescription = "To do pagination or virtual paging, you need to set up a datasource. This page explains how to create an Angular Grid datasource.";
$pageKeyboards = "Angular Grid Datasource";
include '../documentation_header.php';
?>

<div>

    <h2>Datasource</h2>

    <p>
        A datasource is used when you wish to <b>not</b> load all the rows from the server into the client
        in one go. There are two ways to do this, pagination and virtual paging. Each of these methods
        uses a datasource. This section explains creating of a datasource to be used by each of
        these methods.
    </p>

    <h4>Setting up a Datasource</h4>

    <p>
        The datasource is set in the grid options, either before the table is initialised, or by calling setDatasource
        APi method.
    </p>

        <pre>
// before grid initialised
gridOptions.datasource = myDataSource;

// after grid initialised, you can set or change the datasource
gridOptions.api.setDatasource(myDataSource);</pre>

    <pre>
Note: If you are getting the error: "TypeError: Cannot read property 'setDatasource' of undefined" - it's because
you are trying to set the datasource through the setDatasource method, but the API has not been attached
to the gridOptions yet by the grid. To get around this, set the datasource in the 'ready()' method.
    </pre>

    <p>
        Changing the datasource after the grid is initialised will reset the paging in the grid. This is useful if the context of your
        data changes, eg if a filter or other search criteria is changed outside of the grid.
    </p>

    <p>
        The datasource you provide should contain the following items:
    </p>

    <table class="table">
        <tr>
            <th>Attribute</th>
            <th>Description</th>
        </tr>
        <tr>
            <th>getRows(start, finish, callbackSuccess, callbackFail)</th>
            <td>Function you have to implement to get rows. This is explained in detail below.</td>
        </tr>
        <tr>
            <th>pageSize</th>
            <td>How large the pages should be. Each call to your datasource will be for one page.</td>
        </tr>
        <tr>
            <th>rowCount</th>
            <td>The total number of rows, if known, in the data set on the server. If it's unknown, do not set, or set to -1. This
                will put the grid into <i>infinite scrolling</i> mode until the last row is reached. The definition of infinite scrolling
            depends on whether you are doing pagination or virtual paging and is explained in each of those sections.</td>
        </tr>
        <tr>
            <th>overflowSize</th>
            <td>Only used in virtual paging. When infinite scrolling is active, this says how many rows beyond the current last row
                the scrolls should allow to scroll. For example, if 200 rows already loaded from server,
                and overflowSize is 50, the scroll will allow scrolling to row 250.</td>
        </tr>
        <tr>
            <th>maxConcurrentRequests</th>
            <td>Only used in virtual paging. How many requests to hit the server with concurrently. If the max is reached,
                requests are queued. Default is 1, thus by default, only one request will be active at any given time.</td>
        </tr>
        <tr>
            <th>maxPagesInCache</th>
            <td>Only used in virtual paging. How many pages to cache in the client. Default is no limit, so every requested
                page is kept. Use this if you have memory concerns, so pages least recently viewed are purged. If used, make
                sure you have enough pages in cache to display a complete view of the table, otherwise it won't work and an infinite
                loop of requesting pages will happen.</td>
        </tr>
    </table>

    <h4>Function getRows()</h4>

    <p>
        getRows is called by the grid to load pages into the browser side cache of pages. It takes the
        following parameters:<br/>
    <ul>
        <li><b>start:</b> The first row index to get.</li>
        <li><b>finish:</b> The first row index to NOT get.</li>
        <li><b>callbackSuccess:</b> Callback to call for the result when successful.</li>
        <li><b>callbackFail:</b> Callback to call for the result when failed.</li>
    </ul>
    </p>

    <p>
        <b>start</b> and <b>finish</b> define the range expected for the call. For example, if page
        size is 100, the getRows function will be called with start = 0 and end = 100 and the
        grid will expect a result with rows 100 rows 0..99.
    </p>

    <p>
        <b>callbackSuccess</b> and <b>callbackFail</b> are provided to either give the grid
        data, or to let it know the call failed. This is designed to work with the promise pattern
        that Javascript HTTP calls use. The datasource must call one, and exactly one, of these
        methods, to ensure correct operation of the grid.
    </p>

    <p>
        <b>callbackSuccess</b> expects the following parameters:<br/>
    <ul>
        <li><b>rowsThisPage:</b> An array of rows loaded for this page.</li>
        <li><b>lastRow:</b> The total number of rows, if known.</li>
    </ul>
    </p>

    <p>
        <b>callbackFail</b> expects no parameters.<br/>
    </p>

    <p>
        <b>lastRow</b> is used to move the grid out of infinite scrolling. If the last row is known,
        then this should be the index of the last row. If the last row is unknown, then leave
        blank (undefined or null) or -1. This attribute is only used when in infinite scrolling.
        Once the total record count is known, the total numbers of rows is fixed and cannot be
        changed for this grid (unless a new datasource is provided).
    </p>

    <h4>Next Steps</h4>

    <p>
        Now that you can create a datasource, go onto the next sections to set up a datasource
        for pagination and virtual paging.
    </p>

</div>

<?php include '../documentation_footer.php';?>