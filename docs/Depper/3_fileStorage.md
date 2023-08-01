# 3. File Storage

### 1. Configuration
Laravel's filesystem configuration file is located at `config/filesystems.php`. Within this file, you may configure all of your filesystem "disk". The local driver interacts with files stored locally on the server running the Laravel application while the s3 driver is used to write to Amazon's S3 cloud storage service.

### 2. The Local Driver
When using the local driver, all file operations are relative to the root directory defined in your filesystems configuration file. By default, this value is set to the `storage/app` directory. Therefore, the following method would write to `storage/app/example.txt`:

```php
Storage::disk('local')->put('example.txt', 'Contents');
```

