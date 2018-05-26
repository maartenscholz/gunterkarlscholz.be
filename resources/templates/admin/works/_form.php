<?php /** @var \Gks\Domain\Model\Work $work */ ?>
<?php /** @var \Sirius\Validation\ErrorMessage $error */ ?>

<input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
<div class="row">
    <div class="col s12">
        <div class="input-field <?= array_key_exists('type', $errors) ? 'invalid' : '' ?>">
            <select name="type" id="type">
                <?php foreach (\Gks\Domain\Model\Works\Type::TYPES as $type): ?>
                    <option value="<?= $type ?>" <?= array_key_exists('type', $input) && $input['type'] === $type ? 'selected' : (isset($work) && $type === $work->getType()->getValue() ? 'selected' : '') ?>><?= $type ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (array_key_exists('type', $errors)): ?>
                <?php foreach ($errors['type'] as $error): ?>
                    <span class="helper-text" data-error="wrong" data-success="right"><?= $error ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <?php foreach (\Gks\Domain\ValueObjects\Languages::getAll() as $language): ?>
        <div class="col s6">
            <div class="input-field">
                <label for="title_<?= $language ?>">Title (<?= $language ?>)</label>
                <input type="text" name="title[<?= $language ?>]" id="title_<?= $language ?>"
                       class="<?= array_key_exists("title[$language]", $errors) ? 'invalid' : '' ?>""
                value="<?= isset($input['title'][$language]) ? $input['title'][$language] : (isset($work) ? $work->getTitle()->getValue($language) : '') ?>">
                <?php if (array_key_exists("title[$language]", $errors)): ?>
                    <?php foreach ($errors["title[$language]"] as $error): ?>
                        <span class="helper-text"><?= $error ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col s6">
        <div class="input-field <?= array_key_exists('width', $errors) ? 'has-error' : '' ?>">
            <label for="width">Width</label>
            <input type="number" name="width" id="width" class="form-control"
                   value="<?= isset($input['width']) ? $input['width'] : (isset($work) && $work->getDimensions() ? $work->getDimensions()->getWidth() : '') ?>">
            <?php if (array_key_exists('width', $errors)): ?>
                <?php foreach ($errors['width'] as $error): ?>
                    <span class="helper-text" data-error="wrong" data-success="right"><?= $error ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="col s6">
        <div class="input-field <?= array_key_exists('height', $errors) ? 'invalid' : '' ?>">
            <label for="height">Height</label>
            <input type="number" name="height" id="height" class="form-control"
                   value="<?= isset($input['height']) ? $input['height'] : (isset($work) && $work->getDimensions() ? $work->getDimensions()->getHeight() : '') ?>">
            <?php if (array_key_exists('height', $errors)): ?>
                <?php foreach ($errors['height'] as $error): ?>
                    <span class="helper-text" data-error="wrong" data-success="right"><?= $error ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="input-field row">
    <div class="col s12">
        <button type="submit" class="btn"><?= isset($work) ? 'Edit' : 'Add' ?></button>
        <a href="/admin/works" class="btn-flat">back</a>
    </div>
</div>
