{include file="securitycenter_admin_menu.tpl"}
<div class="z-admincontainer">
    <h2>{$title|safetext}</h2>
    <table class="z-datatable">
        <thead>
            <tr>
                <th>{gt text="Variable"}</th>
                <th>{gt text="Variable value"}</th>
            </tr>
        </thead>
        <tbody>
            {section name=arrayvariables loop=$arrayvariables}
            <tr class="{cycle values="z-odd,z-even"}">
                <td>{$arrayvariables[arrayvariables].key|safetext}</td>
                <td>{$arrayvariables[arrayvariables].value|safetext}</td>
            </tr>
            {/section}
        </tbody>
    </table>
</div>
