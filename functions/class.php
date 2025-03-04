<?php
/**
 * 
 */
class Image
{
	function ImageUpload($file, $location, $url)
	{
		if (isset($file)) {
			if ($file['error'] == 0) {
				$allowed_Ext = [
					'jpg',
					'png',
					'jpeg',
					'gif',
					'jfif',
					'webp',
					'svg'
				];
				$target_Dir = $location;
				$img_Ext_Info = new SplFileInfo($file['name']);
				$img_Ext = $img_Ext_Info->getExtension();
				$new_File_Name = uniqid().".$img_Ext";
				$target_File = $target_Dir . $new_File_Name;
				$image_URL = $url . $new_File_Name;

				if (in_array($img_Ext, $allowed_Ext)) {
					if (move_uploaded_file($file['tmp_name'], $target_File)) {
						$img_Path = $target_File;
						$img_URL = $image_URL;
						$image_Array = [
							"url" => $img_URL,
							"path" => $img_Path
						];
						return $image_Array;
					} else {
						?>
						<script>
							console.log('Gambar gagal diupload');
						</script>
						<?php
						return null;
					}
				} else {
					?>
					<script>
						console.log('Ekstensi tidak didukung');
					</script>
					<?php
					return null;
				}
			}
		}
	}

	function ImagesUpload($file, $location)
	{
		$images = [];
		foreach ($file['name'] as $index => $name) {
			if (isset($file)) {
				if ($file['error'][$index] == 0) {
					$allowed_Ext = [
						'jpg',
						'png',
						'jpeg',
						'gif',
						'jfif',
						'webp',
						'svg'
					];
					$target_Dir = $location;
					$img_Ext_Info = new SplFileInfo($name);
					$img_Ext = $img_Ext_Info->getExtension();
					$new_File_Name = uniqid().".$img_Ext";
					$target_File = $target_Dir . $new_File_Name;

					if (in_array($img_Ext, $allowed_Ext)) {
						if (move_uploaded_file($file['tmp_name'][$index], $target_File)) {
							$images[] = $target_File;
						} else {
							?>
							<script>
								console.log('Gambar gagal diupload');
							</script>
							<?php 
						}
					} else {
						?>
						<script>
							console.log('Ekstensi tidak didukung');
						</script>
						<?php			
					}
				}
			}		
		}
		return $images;
	}

	function UpdateImage($file, $location, $url, $path_Image_Old, $URL_Image_Old)
	{
		$image_Array = [];
		if (empty($file['name'])) {
			$image_Array = [
				"url" => $URL_Image_Old,
				"path" => $path_Image_Old
			];
			return $image_Array;
		}

		if (file_exists($path_Image_Old)) {
			if (unlink($path_Image_Old)) {
				if ($file['error'] == 0) {
					$allowed_Ext = [
						'jpg',
						'png',
						'jpeg',
						'gif',
						'jfif',
						'webp',
						'svg'
					];
					$target_Dir = $location;
					$img_Ext_Info = new SplFileInfo($file['name']);
					$img_Ext = $img_Ext_Info->getExtension();
					$new_File_Name = uniqid().".$img_Ext";
					$target_File = $target_Dir . $new_File_Name;
					$image_URL = $url . $new_File_Name;

					if (in_array($img_Ext, $allowed_Ext)) {
						if (move_uploaded_file($file['tmp_name'], $target_File)) {
							$img_Path = $target_File;
							$img_URL = $image_URL;
							$image_Array = [
								"url" => $img_URL,
								"path" => $img_Path
							];
							return $image_Array;
						} else {
							return null;
						}
					} else {
						return null;
					}
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	function DeleteImage($image)
	{
		if (file_exists($image)) {
			if (unlink($image)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
/**
 * 
 */
class Account
{
	private $id;
	private $email;
	private $username;
	private $password;
	private $gambar;

	function __construct($id = null, $email = null, $username = null, $password = null, $gambar = null)
	{
		$this->id = $id;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
		$this->gambar = $gambar;
	}

	function CheckEmail($email)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckAdminDuplication($email)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckAdminDuplicationUpdate($email, $id_Admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email
		AND id != :id_admin";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email,
			":id_admin" => $id_Admin
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectAccount($email)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddAdmin($email, $username, $password, $gambar)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
        (email
            ,username
            ,password
            ,gambar)
        VALUES (:email
            ,:username
            ,:password
            ,:gambar)";

        $stmt = $config->prepare($sql_Add_Query);
        if ($stmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':gambar' => $gambar,
        ])) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
	}

	function HashPassword($password)
	{
		$algorythm1 = "md5";
		$algorythm2 = "sha256";
		$algorythm3 = "tiger192,4";
		$hash1 = hash($algorythm1, $password);
		$hash2 = hash($algorythm2, $hash1);
		$hash3 = hash($algorythm3, $hash2);

		return $hash3;
	}

	function PasswordVerify($password, $hashed_Password)
	{
		$algorythm1 = "md5";
		$algorythm2 = "sha256";
		$algorythm3 = "tiger192,4";
		$hash1 = hash($algorythm1, $password);
		$hash2 = hash($algorythm2, $hash1);
		$hash3 = hash($algorythm3, $hash2);

		if ($hash3 === $hashed_Password) {
			return true;
		} else {
			return false;
		}
	}

	function UpdateAdmin($id_admin, $email, $username, $gambar)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		email = :email,
		username = :username,
		gambar = :gambar
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":email" =>$email,
			":username" =>$username,
			":gambar" =>$gambar,
			":id_admin" =>$id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function GetAdminData()
	{
		$admin_Data = [
			"id" => $this->id,
			"email" => $this->email,
			"username" => $this->username,
			"password" => $this->password,
			"gambar" => $this->gambar
		];

		return $admin_Data;
	}

	function GetAdminsData()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table";

		$stmt = $config->prepare($sql_Select_Query);		
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectAdmin($id_admin)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Select_Query);		
		if ($stmt->execute([
			"id_admin" => $id_admin
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function CheckStatusAdmin($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($status['status'] == "Aktif") {
				$return_Value = [
					"msg" => "Admin saat ini sedang aktif",
					"value" => false 
				];
				return $return_Value;
			} elseif ($status['status'] == "Nonaktif") {
				$return_Value = [
					"value" => true 
				];
				return $return_Value;
			} else {
				$return_Value = [
					"msg" => "Fungsi gagal",
					"value" => false 
				];
				return $return_Value;
			}
		}
		$stmt = null;
	}

	function UpdateStatusAdmin($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;
			if ($status['status'] == "Aktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id = :id_admin";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "Nonaktif",
					":id_admin" => $id_admin
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} elseif ($status['status'] == "Nonaktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id = :id_admin";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "Aktif",
					":id_admin" => $id_admin
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} else {
				$return_Value = [
					"msg" => "Fungsi gagal",
					"value" => false 
				];
				return $return_Value;
			}
		}
		$stmt = null;
	}

	function DeleteAdmin($id_admin)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Produk
{
	function CheckProduk($nama_produk)
	{
		global $config, $table_produk;
		$sql_Check_Query = "SELECT COUNT(*) 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return true;
			} else {
				return false;
			}
		}
		$stmt = null;
	}

	function CheckVarian($varian, $nama_produk)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_Produk = $produk['id_produk'];

				$sql_Check_Query = "SELECT COUNT(*)
				FROM $table_varian
				WHERE
				varian = :varian
				AND
				fid_produk = :id_produk";

				$stmt = $config->prepare($sql_Check_Query);
				if ($stmt->execute([
					":varian" => $varian,
					":id_produk" => $id_Produk
				])) {
					$column = $stmt->fetchColumn();
					if ($colum > 0) {
						return true;
					} else {
						return false;
					}
				}
			}
		}
	}

	function SelectProduks()
	{
		global $config, $table_produk, $table_varian;
		$produks = [];
		$sql_Select_Query = "SELECT * FROM $table_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			$result_Produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			foreach ($result_Produk as $produk) {
				$id_Produk = $produk['id'];
			}
		}
	}

	// function AddProduk()
	// {
		
	// }
}
/**
 * 
 */
class Kategori
{
	
	function CheckKategori($kategori)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		kategori = :kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":kategori" => $kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckKategoriUpdate($kategori, $id_kategori)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		kategori = :kategori
		AND
		id_kategori != :id_kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":kategori" => $kategori,
			":id_kategori" => $id_kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddKategori($kategori, $gambar)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
		(kategori, gambar)
		VALUES
		(:kategori, :gambar)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":kategori" => $kategori,
			":gambar" => $gambar
		])) {
			return true;
		} else {
			return false;
		}
	}

	function SelectKategori($id_kategori)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM
		$table
		WHERE
		id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
	}

	function SelectKategoris()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM $table";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
	}

	function UpdateKategori($kategori, $gambar, $id_kategori)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		kategori = :kategori,
		gambar = :gambar
		WHERE
		id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([ 
			"kategori" => $kategori,
			"gambar" => $gambar,
			$id_kategori => $id_kategori
		])) {
			return true;
		} else {
			return false;
		}
	}
}
?>