<?php /** @var \Gks\Domain\Works\Work $work */ ?>
<?php /** @var \Sirius\Validation\ErrorMessage $error */ ?>

<input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group <?= array_key_exists('type', $errors) ? 'has-error' : '' ?>">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control">
                <?php foreach (\Gks\Domain\Works\Type::TYPES as $type): ?>
                    <option
                        value="<?= $type ?>" <?= array_key_exists('type', $input) && $input['type'] === $type ? 'selected' : (isset($work) && $type === $work->getType()->getValue() ? 'selected' : '') ?>>
                        <?= $type ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (array_key_exists('type', $errors)): ?>
                <?php foreach ($errors['type'] as $error): ?>
                    <div class="help-block"><?= $error ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php foreach (\Gks\Application\I18n\Languages::getAll() as $language): ?>
                <div class="col-md-6">
                    <div class="form-group <?= array_key_exists("title[$language]", $errors) ? 'has-error' : '' ?>">
                        <label for="title_<?= $language ?>">Title (<?= $language ?>)</label>
                        <input type="text" name="title[<?= $language ?>]" id="title_<?= $language ?>"
                               class="form-control"
                               value="<?= isset($input['title'][$language]) ? $input['title'][$language] : (isset($work) ? $work->getTitle()->getValue($language) : '') ?>">
                        <?php if (array_key_exists("title[$language]", $errors)): ?>
                            <?php foreach ($errors["title[$language]"] as $error): ?>
                                <div class="help-block"><?= $error ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group <?= array_key_exists('width', $errors) ? 'has-error' : '' ?>">
                    <label for="width">Width</label>
                    <input type="number" name="width" id="width" class="form-control"
                           value="<?= isset($input['width']) ? $input['width'] : (isset($work) && $work->getDimensions() ? $work->getDimensions()->getWidth() : '') ?>">
                    <?php if (array_key_exists('width', $errors)): ?>
                        <?php foreach ($errors['width'] as $error): ?>
                            <div class="help-block"><?= $error ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group <?= array_key_exists('height', $errors) ? 'has-error' : '' ?>">
                    <label for="height">Height</label>
                    <input type="number" name="height" id="height" class="form-control"
                           value="<?= isset($input['height']) ? $input['height'] : (isset($work) && $work->getDimensions() ? $work->getDimensions()->getHeight() : '') ?>">
                    <?php if (array_key_exists('height', $errors)): ?>
                        <?php foreach ($errors['height'] as $error): ?>
                            <div class="help-block"><?= $error ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?= isset($work) ? 'Edit' : 'Add' ?></button>
            <a href="/admin/works" class="btn btn-link">back</a>
        </div>
    </div>
</div>
