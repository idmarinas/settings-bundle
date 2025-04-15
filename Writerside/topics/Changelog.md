# Changelog

## 1.2.0 - (2025-04-11)

### Changed {id="changed_1"}

* _Changed_ `ChoiceType` form to `EnumType` form type in `AbstractSettingCrudController`

### Added {id="added_1"}

* _Added_ `trans` method to `SettingsEnum` for translation all key. Used by `EnumType`
* Added missing keys of fields **read_only, enabled** for `configureFields` method in
  `AbstractSettingDomainCrudController`,

## Deleted

* _Deleted_ trait `TranslatableChoicesEnumTrait` from `SettingsEnum`

## 1.1.0 - (2025-03-31)

### Added {id="added_1.1.0"}

* _Added_ translation keys for `SettingsEnum` `enum.setting.type.[int|float|bool|string]`
* _Added_ trait `TranslatableChoicesEnumTrait` to `SettingsEnum`
* Added missing fields `type` and `value` in `AbstractSettingsCrudController`

### Changed

* Changed method `configureFields()` of `AbstractSettingCrudController` and `AbstractSettingDomainCrudController` now
  return values with keys. **key is the field name in _snake_case_**

## 1.0.2 - (2025-03-27)

### Added {id="added_1.0.2"}

* _Added_ missing translation key for `translation_domain`

## 1.0.1 - (2025-03-27)

### Fixed

* _Fixed_ error on `AbstractSetting`: The association `Setting#domain` refers to the inverse side field
  `SettingDomain#settings` which does not exist.
* Fixed error with key of translations in `CrudController`

## 1.0.0 - (2025-03-25)

## Release highlights

This is the initial version of %project%.

### Added

**Admin Controllers**

* _Added_ `AbstractSettingCrudController` a basic admin controller for **Settings** in EasyAdminBundle
* _Added_ `AbstractSettingDomainCrudController` a basic admin controller for **Settings Domain** in EasyAdminBundle

**Entities**

* _Added_ `AbstractSetting` basic **Setting** entity
* _Added_ `AbstractSettingDomain` basic **Setting Domain** entity

**Repositories**

* _Added_ `AbstractSettingRepository` base repository for **Setting** entity
* _Added_ `AbstractSettingDomainRepository` base repository for **Setting Domain** entity

**Entity Listeners**

* Added `SettingListener` listener that invalidate or create a cache for `Setting` entity
* Added `SettinDomainListener` listener that invalidate or create a cache for `SettingDomain` entity
  ```php
    // Example
    #[ORM\Entity]
    #[ORM\EntityListeners([SettingListener::class])]
    class Setting extends AbstractSetting
    {
      public const string ENTITY_NAME = 'setting';
    }
    ``` 
