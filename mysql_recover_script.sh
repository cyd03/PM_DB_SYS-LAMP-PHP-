#!/bin/bash

# 数据库用户名
DB_USER="root"
# 数据库密码
DB_PASS="031203cYd?"
# 数据库名称
DB_NAME="exp_4"
# 备份文件目录
BACKUP_DIR="/var/www/html/exp_4/backup"

# 查找最新的备份文件
LATEST_BACKUP=$(ls -t $BACKUP_DIR/*.sql | head -n 1)

if [ -z "$LATEST_BACKUP" ]; then
    echo "No backup file found." >> $BACKUP_DIR/restore.log
    exit 1
fi

# 进行恢复
echo "Starting restore: $LATEST_BACKUP at $(date)" >> $BACKUP_DIR/restore.log
mysql -u $DB_USER -p$DB_PASS $DB_NAME < $LATEST_BACKUP

if [ $? -eq 0 ]; then
    echo "Restore successful: $LATEST_BACKUP at $(date)" >> $BACKUP_DIR/restore.log
else
    echo "Restore failed: $LATEST_BACKUP at $(date)" >> $BACKUP_DIR/restore.log
fi

